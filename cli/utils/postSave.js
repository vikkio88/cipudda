const fs = require('fs');
const { logSuccess, logError, getPost, postSelect, handleApiError, log } = require('./');

module.exports = async ({ API_URL, filePath, key }) => {
    if (fs.existsSync(filePath)) {
        logError(`Post file "${filePath}" already exists.`);
        process.exit(-1);
    }

    let slug = null;
    try {
        slug = await postSelect({ API_URL, key });
        const response = await getPost({ API_URL, slug, key });
        const { body } = response.data.payload;
        fs.writeFileSync(filePath, body, { flag: 'wx' });
    } catch (error) {
        handleApiError(error, `error while saving post ${slug} on file ${filePath}`);
    }

    logSuccess(`post ${slug} saved successfully`);
    log(filePath);
}