<script>
    import { onMount } from "svelte";
    import { pop, replace } from "svelte-spa-router";

    export let params = {};

    let { slug } = params;

    import PostEditor from "../post/PostEditor.svelte";
    import Button from "../common/Button.svelte";
    import api from "../../libs/api";

    let title = null;

    let tags = "";
    let formattedTags = null;

    let postBody = null;

    let response = null;

    onMount(async () => {
        response = await api.getPost(slug);
        slug = response.slug;
        title = response.title;
        postBody = response.body;
        formattedTags = response.tags;
        tags = formattedTags ? formattedTags.split(",").join(" ") : "";
    });

    const updatePost = async () => {
        const data = { slug, title, body: postBody, tags: formattedTags };
        await api.admin.updatePost(slug, data);
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
        <Button lg onClick={() => updatePost()}>Update</Button>
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
