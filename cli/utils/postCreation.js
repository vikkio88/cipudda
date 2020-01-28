const fs = require('fs');
const { Input, List, BooleanPrompt } = require('enquirer');
const { loadPost, createPost, logError, logSuccess, log } = require('./');

const postCreation = async ({ API_URL, key, filePath, FE_URL }) => {
    if (!fs.existsSync(filePath)) {
        logError(`Post file "${filePath}"" does not exist.`);
        process.exit(-1);
    }

    let prompt = new Input({
        message: 'Insert post title',
        initial: 'Some Interesting Title'
    });
    const title = await prompt.run();

    let tags = [];
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
    try {
        await createPost({ slug, title, body, tags }, { API_URL, key });
        logSuccess('success');
        log(`Post available here: ${FE_URL}/#/post/${slug}`);
    } catch ({ response }) {
        logError('failed');
        log('status code: ', response.status);
        logError(response.status);
        console.log();
    }
};


module.exports = postCreation;