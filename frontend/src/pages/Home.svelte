<script>
  import Preview from "../components/post/Preview.svelte";
  import { onMount } from "svelte";
  const { API_URL } = process.env;

  let posts = [];

  onMount(async () => {
    const res = await fetch(`${API_URL}/posts`);
    let response = await res.json();
    posts = response.payload;
  });
</script>

{#each posts as post (post.slug)}
  <Preview {...post} />
{:else}
  <h3>Loading...</h3>
{/each}
