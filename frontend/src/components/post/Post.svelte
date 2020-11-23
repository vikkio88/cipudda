<script>
  import { link } from "svelte-spa-router";
  import { marked } from "cipudda-libs";
  export let title = "";
  export let body = "";
  export let publishedDate = "";
  export let tags = "";
  $: formattedTags = tags ? tags.split(",").map((t) => t.trim()) : [];
</script>

<style>
</style>

<section class="container single-post">
  <h2 class="title">{title}</h2>
  <h3 class="subtitle">{publishedDate}</h3>
  <p class="post-body">
    {@html marked(body)}
  </p>
</section>

{#if tags}
  <section class="tags">
    <h2 class="title">Tags</h2>
    {#each formattedTags as tag}
      <a href={`/posts/tag/${tag}`} use:link class="tag">#{tag}</a>
    {/each}
  </section>
{/if}
