<script>
    import { push } from "svelte-spa-router";
    import { onMount } from "svelte";
    import Button from "../common/Button.svelte";

    const api = process.env.API_URL;

    let posts = [];

    onMount(async () => {
        const res = await fetch(`${api}/posts`);
        let response = await res.json();
        console.log(response);
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
</style>

<div class="page-main">
    <Button onClick={() => push('/')}>Back</Button>

    <div class="posts">
        {#each posts as post (post.slug)}
            <span>{post.title}</span>
        {:else}
            <h3>Loading...</h3>
        {/each}
    </div>
</div>
