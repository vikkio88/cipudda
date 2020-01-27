const axios = require('axios');
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

const CONFIG_FILE = './.cipudda-cli.json';
const loadConfig = () => {
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

const loadPost = (filePath, title) => {
    const body = fs.readFileSync(filePath).toString();
    const slug = `${title.toLocaleLowerCase().replace(/\s/g, '-')}-${generateId()}`;
    return { body, slug };
}
const createPost = async ({ slug, title, body, tags }, { API_URL, key }) => {
    log('sending post');
    return axios.post(`${API_URL}/posts`, { slug, title, body, tags: tags.join(', ') }, { headers: { authorization: key } })
}

module.exports = {
    loadConfig,
    loadPost,
    createPost,
    logSuccess,
    logError,
    log
};