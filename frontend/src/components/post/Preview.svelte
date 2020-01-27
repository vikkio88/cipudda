<script>
  import { link } from "svelte-spa-router";
  import marked from "marked";
  export let slug = "";
  export let title = "";
  export let body = "";
  export let publishedDate = "";
  export let tags = [];
</script>

<style>
  .index-item {
    width: 80vw;
  }

  @media screen and (max-width: 500px) {
    .index-item {
      width: 90vw;
    }
  }
</style>

<section class="nes-container with-title index-item">
  <h2 class="title blackbg">{title}</h2>
  <h3 class="subtitle">{publishedDate}</h3>
  <p class="post-body">
    {@html marked(body)}
  </p>

  <a href={`/post/${slug}`} use:link>read more...</a>
</section>
