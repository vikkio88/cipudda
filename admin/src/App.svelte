<script>
	const api = process.env.API_URL;
</script>

<main>
	<h1>Cipudda Admin panel</h1>
	<h2>website on: {api}</h2>
	
</main>

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
</style>