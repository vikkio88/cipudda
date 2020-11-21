<script>
    import { push } from "svelte-spa-router";

    import PostEditor from '../post/PostEditor.svelte';
    import Button from "../common/Button.svelte";

    const api = process.env.API_URL;
    const key = process.env.API_KEY;

    let title = "Some Title";
    let formattedTags = "";
    let slug = null;
    

    let postBody = "`Insert Post body` [here](google.com)";

    let response = null;

    const createPost = async () => {
        const data = { slug, title, body: postBody, tags: formattedTags };

        response = await fetch(`${api}/admin/posts`, {
            method: "post",
            headers: {
                "x-api-key": key,
            },
            body: JSON.stringify(data),
        });
        response = response.json();
        push("/posts");
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
</style>

<div class="page-main">
    <div class="actions-wrapper">
        <Button lg onClick={() => push('/')}>Back</Button>
        <Button lg onClick={() => createPost()}>Create</Button>
    </div>
    <PostEditor
        bind:title={title}
        bind:postBody={postBody}
        bind:formattedTags={formattedTags}
        bind:slug={slug}
    />
</div>
