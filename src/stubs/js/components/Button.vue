<template>
    <button :type="type">
        <slot />
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
                validator: value =>
                    ['submit', 'reset', 'button'].includes(value),
            },
        },
    }
</script>
