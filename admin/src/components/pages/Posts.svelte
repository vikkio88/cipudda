<script>
    import { push } from "svelte-spa-router";
    import { onMount } from "svelte";
    import Button from "../common/Button.svelte";
    import Post from "../common/PostListItem.svelte";

    const api = process.env.API_URL;

    let posts = [];

    onMount(async () => {
        const res = await fetch(`${api}/posts`);
        let response = await res.json();
        posts = response.payload;
    });
</script>

<style>
    .page-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
    }
    .posts {
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        width: 80%;
    }
</style>

<div class="page-main">
    <Button lg onClick={() => push('/')}>Back</Button>

    <div class="posts">
        {#each posts as post (post.slug)}
            <Post {...post} />
        {:else}
            <h3>Loading...</h3>
        {/each}
    </div>
</div>
