<script>
    import Button from "./Button.svelte";

    export let onClick = () => {};
    export let disabled = false;

    let clicked = false;
</script>

<style>
    .wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin: 5px;
    }
</style>

{#if !clicked}
    <Button
        onClick={() => {
            clicked = true;
        }}
        {disabled}>
        <slot />
    </Button>
{:else}
    <div class="wrapper">
        <Button sm {onClick}>Confirm</Button>
        <Button
            sm
            onClick={() => {
                clicked = false;
            }}>
            Cancel
        </Button>
    </div>
{/if}
