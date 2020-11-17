<script>
    export let onClick = () => {};
    export let disabled = false;
    export let lg = false;
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
</style>

<button class={`btn${lg ? ' btn-lg' : ''}`} on:click={onClick} {disabled}>
    <slot />
</button>
