const { Input, List, BooleanPrompt } = require('enquirer');
const fs = require('fs');
const { logSuccess, loadPost, logError, getPost, postSelect, handleApiError, log, putPost } = require('.');

module.exports = async ({ API_URL, FE_URL, filePath, key }) => {
    if (!fs.existsSync(filePath)) {
        logError(`Post file "${filePath}" does not exist.`);
        process.exit(-1);
    }

    let slug = null;
    let response = null;
    try {
        slug = await postSelect({ API_URL, key });
        response = await getPost({ API_URL, slug, key });
        let { title, tags, publishedDate } = response.data.payload;
        const { body } = loadPost(filePath);

        let prompt = new Input({
            message: 'Insert post title',
            initial: title
        });

        title = await prompt.run();
        log(`current tags: ${tags}`);
        prompt = new BooleanPrompt({ message: "Do you want to update the tags?" });
        let choice = await prompt.run();
        if (choice) {
            prompt = new List({
                name: 'keywords',
                message: 'Type comma-separated keywords'
            });
            tags = await prompt.run();
        }

        log(`published date: ${publishedDate}`);
        prompt = new BooleanPrompt({ message: "Do you want to update the published date to now?" });
        choice = await prompt.run();
        if (choice) {
            publishedDate = (new Date()).toISOString();
        }

        response = await putPost({ slug, title, body, tags, publishedDate, API_URL, key })
    } catch (error) {
        
        console.error(error.response.body);
        process.exit(1);

        handleApiError(error, `error while saving post ${slug} on file ${filePath}`);
    }

    logSuccess(`post ${slug} updated successfully`);
    log(`Post available here: ${FE_URL}/#/post/${slug}`);
}