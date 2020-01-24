<script>
  import Post from "../components/post/Post.svelte";
  import { onMount } from "svelte";
  export let params = {};

  const { slug } = params;
  const { API_URL } = process.env;
  let post = null;

  onMount(async () => {
    const res = await fetch(`${API_URL}/post/${slug}`);
    const response = await res.json();
    post = response.payload;
  });
</script>

{#if post}
  <Post {...post} />
{:else}
  <h3>Loading...</h3>
{/if}
