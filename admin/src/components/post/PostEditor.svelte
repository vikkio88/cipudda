<script>
    import { marked } from "cipudda-libs";
    const generateId = () => Math.random().toString(36).substr(2, 5);

    export let forceSlug = false;
    export let slug = null;
    export let title = "";
    export let formattedTags = "";
    export let tags = "";
    export let postBody = "";

    $: formattedTags = tags.trim().split(" ").join(",");
    $: slug = forceSlug
        ? slug
        : title
        ? `${title
              .toString()
              .toLowerCase()
              .normalize("NFD")
              .trim()
              .replace(/\s+/g, "-")
              .replace(/[^\w\-]+/g, "")
              .replace(/\-\-+/g, "-")}-${generateId()}`
        : null;
</script>

<style>
    .post-wrapper {
        flex: 1;
        width: 100%;
        display: flex;
        flex-direction: row;
    }

    .source {
        flex: 1;
    }

    .source textarea {
        width: 100%;
        height: 100%;
    }

    .preview {
        flex: 1;
        display: block;
        text-align: left;
        padding-left: 10px;
    }
</style>

<div class="post-wrapper">
    <div class="source">
        <input bind:value={title} type="text" placeholder="Enter Title" />
        <input
            bind:value={tags}
            size="30"
            type="text"
            placeholder="Enter tags" />
        <textarea
            cols="2"
            rows="10"
            bind:value={postBody}
            placeholder="Enter markdown here" />
    </div>
    <div class="preview">
        <h2>Title: {title}</h2>
        <h3>tags: {formattedTags}</h3>
        <strong>slug: {slug ? slug : '-'}</strong>
        {@html marked(postBody)}
    </div>
</div>
