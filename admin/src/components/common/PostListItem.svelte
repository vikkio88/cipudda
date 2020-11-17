<script>
import Button from "./Button.svelte";

    export let slug = "";
    export let title = "";
    export let publishedDate = "";
</script>

<style>
    .post {
        border: solid 1px #666;
        border-radius: 2px;
        padding: 10px;
        width: 100%;
        height: 80px;
        margin-top: 15px;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }
    .post h2 {
        margin: 0;
    }

    .info {
        flex: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .actions {
        flex: 1;
    }
</style>

<div class="post">
    <div class="info">
        <h2>{title}</h2>
        <strong>{slug}</strong>
        <span>{publishedDate}</span>
    </div>
    <div class="actions" >
        <Button>Edit</Button>
        <Button>Delete</Button>
    </div>

</div>
