const api = process.env.API_URL;
const key = process.env.API_KEY;

export default {
    async getPosts() {
        const res = await fetch(`${api}/posts`);
        const response = await res.json();
        return response.payload;
    },
    async getPost(slug) {
        const res = await fetch(`${api}/posts/${slug}`);
        const response = await res.json();
        return response.payload;
    },

    admin: {
        async getPosts() {
            const res = await fetch(`${api}/admin/posts`, {
                headers: {
                    'x-api-key': key,
                }
            });
            const response = await res.json();
            return response.payload;
        },
        async createPost(body) {
            const res = await fetch(`${api}/admin/posts`, {
                method: 'post',
                headers: {
                    'x-api-key': key,
                },
                body: JSON.stringify(body),
            });
            const response = await res.json();
            return response.payload;
        },
        async updatePost(slug, body) {
            const res = await fetch(`${api}/admin/posts/${slug}`, {
                method: 'put',
                headers: {
                    'x-api-key': key,
                },
                body: JSON.stringify(body),
            });
            const response = await res.json();
            return response.payload;
        },
        async deletePost(slug) {
            const res = await fetch(`${api}/admin/posts/${slug}`, {
                method: 'delete',
                headers: {
                    'x-api-key': key,
                }
            });
            const response = await res.json();
            return response.payload;
        }
    }

};