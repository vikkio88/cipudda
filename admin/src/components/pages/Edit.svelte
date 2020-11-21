<script>
    import { onMount } from "svelte";
    import { push } from "svelte-spa-router";

    export let params = {};

    let { slug } = params;

    import PostEditor from "../post/PostEditor.svelte";
    import Button from "../common/Button.svelte";

    const api = process.env.API_URL;
    const key = process.env.API_KEY;

    let title = null;

    let tags = "";
    let formattedTags = null;

    let postBody = null;

    let response = null;

    onMount(async () => {
        const res = await getPost();
        response = res.payload;

        slug = response.slug;
        title = response.title;
        postBody = response.body;
        formattedTags = response.tags;
        tags = formattedTags ? formattedTags.split(",").join(" ") : "";
    });

    const getPost = async () => {
        const res = await fetch(`${api}/posts/${slug}`);
        return await res.json();
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
        <Button lg onClick={() => console.log('Update')}>Update</Button>
    </div>
    {#if !response}
        <h2>Loading...</h2>
    {:else}
        <PostEditor
            bind:title
            bind:postBody
            bind:tags
            bind:formattedTags
            {slug}
            forceSlug />
    {/if}
</div>
