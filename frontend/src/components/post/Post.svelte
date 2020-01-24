<script>
  import marked from "marked";
  import { READ_MORE_PLACEHOLDER } from "../../config";
  export let title = "";
  export let body = "";
  export let publishedDate = "";

  body = body.replace(READ_MORE_PLACEHOLDER, "");
</script>

<style>
  .single-post {
    min-height: 60vh;
  }
  .single-post p {
    padding: 0px;
  }
</style>

<section class="nes-container with-title single-post">
  <h2 class="title blackbg">{title}</h2>
  <h3 class="subtitle">{publishedDate}</h3>
  <p class="post-body">
    {@html marked(body)}
  </p>
</section>
