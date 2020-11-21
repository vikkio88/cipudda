<script>
    import { push } from "svelte-spa-router";
    import { onMount } from "svelte";
    import api from '../../libs/api';

    import Button from "../common/Button.svelte";
    import Post from "../post/PostListItem.svelte";

    let posts = [];

    onMount(async () => {
        posts = await api.admin.getPosts();
    });

    const onDeleted = slug => {
        posts = posts.filter(p => p.slug !== slug);
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
            <Post {...post} onDeleted={onDeleted}/>
        {:else}
            <h3>No Posts...</h3>
        {/each}
    </div>
</div>
