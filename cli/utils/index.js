const axios = require('axios');
const { Select } = require('enquirer');
const fs = require('fs');
const os = require('os');
const path = require('path');
const chalk = require('chalk');

const logError = message => {
    console.log(chalk.red(chalk.bold(message)));
};

const logSuccess = message => {
    console.log(chalk.green(chalk.bold(message)));
};

const log = message => console.log(chalk.bold(message));

const loadConfig = (devMode = false) => {
    const CONFIG_FILE = `./.cipudda-cli${devMode ? '-dev' : ''}.json`;
    const home = os.homedir();
    const configPath = path.resolve(home, CONFIG_FILE);
    if (!fs.existsSync(configPath)) {
        logError(`config file: ${configPath} does not exist`);
        logError(`please create it`);
        process.exit(-1);
    }
    const body = fs.readFileSync(configPath).toString();
    return JSON.parse(body);
};

const generateId = () => Math.random().toString(36).substr(2, 5);

const loadPost = (filePath, title = null) => {
    const body = fs.readFileSync(filePath).toString();
    const slug = title ? `${title.toLocaleLowerCase().replace(/\s/g, '-')}-${generateId()}` : null;
    return { body, slug };
};

const createPost = async ({ slug, title, body, tags, API_URL, key }) => {
    log('sending post');
    return axios.post(`${API_URL}/admin/posts`, { slug, title, body, tags: tags.join(', ') }, { headers: { authorization: key } });
};

const getPosts = async ({ API_URL, key }) => {
    log('fetching posts');
    return axios.get(`${API_URL}/admin/posts`, { headers: { authorization: key } });
};

const getPost = async ({ API_URL, slug, key }) => {
    log(`fetching post ${slug}`);
    return axios.get(`${API_URL}/post/${slug}`, { headers: { authorization: key } });
};

const deletePost = async ({ API_URL, slug, key }) => {
    log(`deleting post ${slug}`);
    return axios.delete(`${API_URL}/admin/post/${slug}`, { headers: { authorization: key } });
};

const putPost = async ({ slug, title, body, tags, publishedDate, API_URL, key }) => {
    log(`updating post ${slug}`);
    return axios.put(`${API_URL}/admin/post/${slug}`, { slug, title, body, tags, publishedDate }, { headers: { authorization: key } });
};

const postSelect = async ({ API_URL, key }) => {
    let posts = [];
    try {
        response = await getPosts({ API_URL, key });
        const { data: { payload } } = response;
        posts = payload;
    } catch (error) {
        logError('error while fetching posts');
        process.exit(1);
    }
    logSuccess('post loaded');

    let prompt = new Select({
        name: 'Post',
        message: 'Pick a post',
        choices: posts.map(p => {
            return {
                name: p.slug,
                message: `${p.title} - ${p.publishedDate}`
            };
        })
    });

    const slug = await prompt.run();
    return slug;
};

const handleApiError = (error, message) => {
    if (!(error instanceof Object && error.response)) {
        throw error;
    }

    const { response } = error;
    logError(message);
    log('status code: ');
    logError(response.status);
    console.log();
    process.exit(1);
}



module.exports = {
    loadConfig,
    loadPost,

    createPost,
    getPosts,
    deletePost,
    getPost,
    putPost,

    postSelect,

    handleApiError,
    logSuccess,
    logError,
    log
};