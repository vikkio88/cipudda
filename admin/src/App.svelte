<script>
	import Router from "svelte-spa-router";

	import Main from "./components/pages/Main.svelte";

	const routes = {
		"/": Main,
	};

	const api = process.env.API_URL;
</script>

<style>
	main {
		text-align: center;
		max-width: 240px;
		margin: 0 auto;
	}

	h1 {
		margin: 0;
		color: #ff3e00;
		text-transform: uppercase;
		font-size: 3em;
		font-weight: 100;
	}

	h2 {
		font-size: 1.5em;
		margin: 0;
	}

	@media (min-width: 640px) {
		main {
			max-width: none;
		}
	}

	.admin-body {
		display: flex;
		width: 100%;
		min-height: 90vh;
		flex-direction: row;
		justify-content: center;
		align-items: center;
	}
</style>

<main>
	<h1>Cipudda Admin panel</h1>
	<h2>website on: {api}</h2>
	<div class="admin-body">
		<Router {routes} />
	</div>
</main>
