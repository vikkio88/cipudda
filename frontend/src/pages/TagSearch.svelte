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

{#if posts}
  {#each posts as post}
    <Preview {...post} />
  {:else}
    <div class="no-result">
      No posts matching tag
      <strong>{`${tag}`}</strong>
    </div>
  {/each}
{:else}
  <h3>Loading...</h3>
{/if}
