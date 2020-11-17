<script>
    import {push} from "svelte-spa-router";
    import {marked} from "cipudda-libs";

    import Button from "../common/Button.svelte";

    const generateId = () => Math.random().toString(36).substr(2, 5);

    const api = process.env.API_URL;
    const key = process.env.API_KEY;

    let title = "Some Title";
    let tags = "";
    $: formattedTags = tags.trim().split(' ').join(',');
    $: slug = title
        ? `${title
            .toString()
            .toLowerCase()
            .normalize("NFD")
            .trim()
            .replace(/\s+/g, "-")
            .replace(/[^\w\-]+/g, "")
            .replace(/\-\-+/g, "-")}-${generateId()}`
        : null;

    let postBody = "`Insert Post body` [here](google.com)";

    let response = null;

    const createPost = async () => {
        const data = {slug, title, body: postBody, tags: formattedTags};

        response = await fetch(`${api}/admin/posts`, {
            method: 'post',
            headers: {
                'x-api-key': key,
            },
            body: JSON.stringify(data),
        });
        response = response.json();
    };
</script>

<style>
    .page-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
    }

    .post-wrapper {
        flex: 1;
        width: 100%;
        display: flex;
        flex-direction: row;
    }

    .source {
        flex: 1;
    }

    .source textarea {
        width: 100%;
        height: 100%;
    }

    .preview {
        flex: 1;
        display: block;
        text-align: left;
        padding-left: 10px;
    }
</style>

<div class="page-main">
    <div class="actions-wrapper">
        <Button lg onClick={() => push('/')}>Back</Button>
        <Button lg onClick={() => createPost()}>Create</Button>
    </div>

    <div class="post-wrapper">
        <div class="source">
            <input bind:value={title} type="text" placeholder="Enter Title"/>
            <input bind:value={tags} size="30" type="text" placeholder="Enter tags"/>
            <textarea
                    cols="2"
                    rows="10"
                    bind:value={postBody}
                    placeholder="Enter markdown here"/>
        </div>
        <div class="preview">
            <h2>Title: {title}</h2>
            <h3>tags: {formattedTags}</h3>
            <strong>slug: {slug ? slug : '-'}</strong>
            {@html marked(postBody)}
        </div>
    </div>
</div>
