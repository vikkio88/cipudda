const argv = require('minimist')(process.argv.slice(2));
const postCreation = require('./utils/postCreation');
const { loadConfig, logError } = require('./utils');
const { API_URL, FE_URL, key } = loadConfig();


const { f, e } = argv;

const filePath = f;
const edit = e;
const main = async () => {
    if (!((typeof filePath === 'string') ^ (typeof edit === 'boolean'))) {
        logError('No file specified -f, nor in edit mode -e');
        process.exit(-1);
    }

    if (filePath) {
        await postCreation({ API_URL, key, filePath, FE_URL });
        process.exit(0);
    }

    if (edit) {
        console.log('edit');
        process.exit(0);
    }
}

main();