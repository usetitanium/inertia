<template>
    <div>
        <label v-if="label" :for="id">{{ label }}</label>
        <input
            :type="type"
            :id="id"
            :autofocus="autofocus"
            :value="value"
            @input="$emit('input', $event.target.value)"
            v-bind="$attrs"
        />
        <span v-for="error in errors">{{ error }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            autofocus: {
                type: Boolean,
                default: false,
            },
            label: {
                type: String,
            },
            type: {
                default: 'text',
                validator: value =>
                    [
                        'email',
                        'number',
                        'password',
                        'search',
                        'tel',
                        'text',
                        'url',
                    ].includes(value),
            },
            value: {},
            errors: {
                type: Array,
                default: () => [],
            },
        },
    }
</script>
