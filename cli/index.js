const argv = require('minimist')(process.argv.slice(2));
const postCreate = require('./utils/postCreation');
const postDelete = require('./utils/postDelete');
const postSave = require('./utils/postSave');
const postEdit = require('./utils/postEdit');
const { loadConfig, logError, log } = require('./utils');
const { API_URL, FE_URL, key } = loadConfig();

const MODES = {
    CREATE: 'createMode',
    EDIT: 'editMode',
    DELETE: 'deleteMode',
    SAVE: 'saveMode'
};

const actions = {
    [MODES.CREATE]: postCreate,
    [MODES.EDIT]: postEdit,
    [MODES.DELETE]: postDelete,
    [MODES.SAVE]: postSave
};

const { e, c, d, f, s } = argv;

const switches = {
    [MODES.CREATE]: c,
    [MODES.EDIT]: e,
    [MODES.DELETE]: d,
    [MODES.SAVE]: s
};
const filePath = f;

const main = async () => {
    const filteredSwitches = Object.keys(switches).filter(mode => {
        return Boolean(switches[mode]);
    });

    if (filteredSwitches.length !== 1) {
        logError('You need to select one mode');
        log('-c : create mode (needs -f PATH)');
        log('-s : save (needs -f PATH)');
        log('-e : edit mode (needs -f PATH)');
        log('-d : delete');
        process.exit(-1);
    }

    const mode = filteredSwitches[0];

    if (([MODES.EDIT, MODES.CREATE, MODES.SAVE].includes(mode)) && !((typeof filePath === 'string'))) {
        logError('No file specified -f');
        log(`I need a markdown file to work with on ${mode} mode`);
        log('specify a file with -f FILEPATH');
        process.exit(-1);
    }
    const action = actions[mode];
    try {
        await action({ API_URL, key, filePath, FE_URL });
    } catch (error) {
        logError('Error: something was not handled correctly');
        console.log();
        console.log(error);
        console.log();
        log(`maybe the api are down on ${API_URL} ?`)
        log(`check: ${API_URL}/ping`)
    }
    process.exit(0);
}


main();