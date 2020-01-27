<script>
  import Preview from "../components/post/Preview.svelte";
  import { onMount } from "svelte";
  const { API_URL } = process.env;

  export let params = {};
  let { tag } = params;
  let posts = null;

  onMount(async () => {
    const res = await fetch(`${API_URL}/posts/tags?tag=${tag}`);
    const response = await res.json();
    posts = response.payload;
  });
</script>

<style>
  div.search-head {
    font-size: 20px;
    padding: 20px;
  }

  div.search-head strong {
    margin-left: 10px;
  }
</style>

{#if posts}
  <div class="search-head">
    Posts matching tag:
    <strong>{`${tag}`}</strong>
  </div>
  {#each posts as post}
    <Preview {...post} hideBody />
  {:else}
    <div class="no-result">No posts.</div>
  {/each}
{:else}
  <h3>Loading...</h3>
{/if}
