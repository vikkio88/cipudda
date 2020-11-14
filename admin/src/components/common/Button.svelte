<script>
    export let onClick = () =>{}
</script>

<style>
    button.btn {
        background: transparent;
        padding:10px;
        font-size: 2em;
        margin: 5px;
    }
</style>

<button class="btn" on:click={onClick}>
    <slot></slot>
</button>