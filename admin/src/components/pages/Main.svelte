<script>
    import Button from "../common/Button.svelte";
    import { push } from "svelte-spa-router";
</script>

<style>
    .page-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="page-main">
    <Button lg fluid onClick={() => push('/posts')}>Posts</Button>
    <Button lg fluid onClick={() => push('/create')}>Create</Button>
</div>
