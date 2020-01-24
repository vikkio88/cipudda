<script>
  import Router from "svelte-spa-router";

  import Header from "./components/pages/Header.svelte";
  import Footer from "./components/pages/Footer.svelte";
  import Home from "./pages/Home.svelte";
  import Post from "./pages/Post.svelte";
  const routes = {
    "/": Home,
    "/post/:slug": Post,
    "*": Home
  };
</script>

<Header />
<Router {routes} />
<Footer />
