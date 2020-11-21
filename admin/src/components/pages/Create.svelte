<script>
    import { pop, replace } from "svelte-spa-router";

    import PostEditor from "../post/PostEditor.svelte";
    import Button from "../common/Button.svelte";
    import api from "../../libs/api";

    let title = "Some Title";
    let formattedTags = "";
    let slug = null;

    let postBody = "`Insert Post body` [here](google.com)";

    const createPost = async () => {
        const data = { slug, title, body: postBody, tags: formattedTags };
        await api.admin.createPost(data);
        replace("/posts");
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
        <Button lg onClick={() => pop()}>Back</Button>
        <Button lg onClick={() => createPost()}>Create</Button>
    </div>
    <PostEditor bind:title bind:postBody bind:formattedTags bind:slug />
</div>
