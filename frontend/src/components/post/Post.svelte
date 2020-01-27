<script>
  import { link } from "svelte-spa-router";
  import marked from "marked";
  export let title = "";
  export let body = "";
  export let publishedDate = "";
  export let tags = "";
  $: formattedTags = tags ? tags.split(",").map(t => t.trim()) : [];
</script>

<style>
  .single-post {
    min-height: 60vh;
  }
  p.post-body {
    width: 95vw;
  }

  .single-post p {
    padding: 0px;
  }
  a.tag {
    margin-left: 5px;
    margin-right: 5px;
  }
</style>

<section class="nes-container with-title single-post">
  <h2 class="title blackbg">{title}</h2>
  <h3 class="subtitle">{publishedDate}</h3>
  <p class="post-body">
    {@html marked(body)}
  </p>
</section>

{#if tags}
  <section class="nes-container with-title">
    <h2 class="title blackbg">Tags</h2>
    {#each formattedTags as tag}
      <a href={`/posts/tags/${tag}`} use:link class="tag">#{tag}</a>
    {/each}
  </section>
{/if}
