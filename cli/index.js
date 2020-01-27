const fs = require('fs');
const { Input, List, BooleanPrompt } = require('enquirer');
const argv = require('minimist')(process.argv.slice(2));
const { loadConfig, loadPost, createPost } = require('./utils');
const { API_URL, FE_URL, key } = loadConfig();

const { f, file } = argv;

const filePath = f || file;

if (!(typeof filePath === 'string')) {
    console.log('No file specified -f');
    process.exit(-1);
}

if (!fs.existsSync(filePath)) {
    console.log(`Post file "${filePath}"" does not exist.`);
    process.exit(-1);
}

const main = async () => {
    let prompt = new Input({
        message: 'Insert post title',
        initial: 'Some Interesting Title'
    });
    const title = await prompt.run();

    let tags = null;
    prompt = new BooleanPrompt({ message: "Do you want to add any tag?" });
    const addTags = await prompt.run();
    if (addTags) {
        prompt = new List({
            name: 'keywords',
            message: 'Type comma-separated keywords'
        });

        tags = await prompt.run();
    }

    const { body, slug } = loadPost(filePath, title);
    createPost({ slug, title, body }, { API_URL, FE_URL, key });
}


main();