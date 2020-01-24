<script>
  import { push } from "svelte-spa-router";
</script>

<header class="header" on:click={() => push('/')}>
  <h1>/cipudda</h1>
  <img src="images/me.jpg" class="nes-avatar is-large is-rounded" alt="me" />
  <p class="home-title">my small blog</p>
</header>
