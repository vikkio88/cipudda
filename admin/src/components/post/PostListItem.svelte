<script>
    import api from "../../libs/api";
    import { push } from "svelte-spa-router";

    import Button from "../common/Button.svelte";
    import ConfirmButton from "../common/ConfirmButton.svelte";

    export let slug = "";
    export let title = "";
    export let publishedDate = "";

    export let onDeleted = () => {};

    const onDelete = async (slug) => {
        await api.admin.deletePost(slug);
        onDeleted(slug);
    };
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
        flex: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .actions {
        flex: 1;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="post">
    <div class="info">
        <h2>{title}</h2>
        <strong>{slug}</strong>
        <span>{publishedDate}</span>
    </div>
    <div class="actions">
        <Button onClick={() => push(`/edit/${slug}`)}>Edit</Button>
        <ConfirmButton onClick={() => onDelete(slug)}>Delete</ConfirmButton>
    </div>
</div>
