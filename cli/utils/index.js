const axios = require('axios');
const fs = require('fs');
const os = require('os');
const path = require('path');

const CONFIG_FILE = './.cipudda-cli.json';
const loadConfig = () => {
    const home = os.homedir();
    const configPath = path.resolve(home, CONFIG_FILE);
    if (!fs.existsSync(configPath)) {
        console.log(`config file: ${configPath} does not exist`);
        console.log(`please create it`);
        process.exit(-1);
    }
    const body = fs.readFileSync(configPath).toString();
    return JSON.parse(body);
};

const generateId = () => Math.random().toString(36).substr(2, 5);

const loadPost = (filePath, title) => {
    const body = fs.readFileSync(filePath).toString();
    const slug = `${title.toLocaleLowerCase().replace(/\s/g, '-')}-${generateId()}`;
    return { body, slug };
}
const createPost = ({ slug, title, body }, { API_URL, FE_URL, key }) => {
    console.log('sending post');
    axios.post(`${API_URL}/posts`, { slug, title, body }, { headers: { authorization: key } })
        .then(() => {
            console.log('success');
            console.log(`Post available here: ${FE_URL}/#/post/${slug}`);
        }).catch(({ response }) => {
            console.error('failed status code: ', response.status);
        });
}

module.exports = {
    loadConfig,
    loadPost,
    createPost
};