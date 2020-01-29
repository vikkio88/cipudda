
const { logSuccess, deletePost, postSelect, handleApiError } = require('./');

module.exports = async ({ API_URL, key }) => {
    let slug = null;

    try {
        slug = await postSelect({ API_URL, key });
        await deletePost({ API_URL, slug, key });
    } catch (error) {
        handleApiError(error, `error while deleting post ${slug}`);
    }

    logSuccess(`post ${slug} deleted successfully`);
}