<script>
    export let onClick = () => {};
    export let disabled = false;
    export let lg = false;
    export let sm = false;
    export let fluid = false;
</script>

<style>
    button.btn {
        background: transparent;
        padding: 5px;
        font-size: 1.2em;
        margin: 2px;
    }

    button.btn-lg {
        padding: 10px;
        font-size: 2em;
        margin: 5px;
    }
    button.btn-sm {
        padding: 2px;
        font-size: 1em;
        margin: 2px;
    }

    .fluid {
        width: 100%;
    }
</style>

<button
    class={`btn${fluid ? ' fluid' : ''}${lg ? ' btn-lg' : ''}${sm && !lg ? ' btn-sm' : ''}`}
    on:click={onClick}
    {disabled}>
    <slot />
</button>
