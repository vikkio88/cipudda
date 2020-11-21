<script>
  import { link } from "svelte-spa-router";
  import { marked } from "cipudda-libs";
  export let slug = "";
  export let title = "";
  export let body = "";
  export let publishedDate = "";
  export let hideBody = false;
</script>

<style>
  .index-item {
    min-width: 70vw;
  }

  @media screen and (max-width: 500px) {
    .index-item {
      width: 70vw;
    }
  }
  div.section-bottom {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
  }
</style>

<section class="container index-item">
  <h2 class="title">{title}</h2>
  <h3 class="subtitle">{publishedDate}</h3>
  {#if !hideBody}
    <p class="post-body">
      {@html marked(body)}
    </p>
  {/if}
  <div class="section-bottom">
    <a href={`/post/${slug}`} use:link>read more...</a>
  </div>
</section>
