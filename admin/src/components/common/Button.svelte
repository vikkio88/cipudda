<script>
    export let onClick = () =>{};
    export let disabled = false;
</script>

<style>
    button.btn {
        background: transparent;
        padding:10px;
        font-size: 2em;
        margin: 5px;
    }
</style>

<button class="btn" on:click={onClick} disabled={disabled}>
    <slot></slot>
</button>