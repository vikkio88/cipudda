<script>
  import Router from "svelte-spa-router";

  import Header from "./components/pages/Header.svelte";
  import Footer from "./components/pages/Footer.svelte";
  import Home from "./pages/Home.svelte";
  import Post from "./pages/Post.svelte";
  import TagSearch from "./pages/TagSearch.svelte";
  import NotFound from "./pages/NotFound.svelte";

  const routes = {
    "/": Home,
    "/post/:slug": Post,
    "/posts/tag/:tag": TagSearch,
    "*": NotFound
  };
</script>

<Header />
<main>
  <Router {routes} />
</main>
<Footer />
