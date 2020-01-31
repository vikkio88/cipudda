<script>
  import { push } from "svelte-spa-router";
</script>
<style>
@media screen and (max-width: 500px) {
  .home-title {
    font-size: smaller;
  }
}
</style>

<header class="header" on:click={() => push('/')}>
  <h1>/cipudda</h1>
  <p class="home-title">a small programming blog</p>
</header>
