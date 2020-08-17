<template>
    <div>
        <input
            type="checkbox"
            :id="id"
            :checked="value"
            @change="$emit('input', $event.target.checked)"
        />
        <label v-if="label" :for="id">{{ label }}</label>
    </div>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
            },
            value: {},
        },
    }
</script>
