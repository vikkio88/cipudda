<script>
  import { link } from "svelte-spa-router";
  import { marked } from "cipudda-libs";
  export let title = "";
  export let body = "";
  export let publishedDate = "";
  export let tags = "";
  $: formattedTags = tags ? tags.split(",").map(t => t.trim()) : [];
</script>

<style>
  .single-post {
    width: 85vw;
  }

  @media screen and (max-width: 650px) {
    .single-post {
      width: 98vw;
    }
    .tags {
      width: 98vw;
      display: flex;
    }
    .tags p {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
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
  <section class="nes-container with-title tags">
    <h2 class="title blackbg">Tags</h2>
    <p>
      {#each formattedTags as tag}
        <a href={`/posts/tag/${tag}`} use:link class="tag">#{tag}</a>
      {/each}
    </p>
  </section>
{/if}
