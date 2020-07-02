<script>
    export default {
        props: {
            to: {
                type: String,
                required: true,
            },
            data: {
                type: Object,
                default: () => ({}),
            },
        },

        methods: {
            handler() {
                this.$inertia.post(this.to, this.data)
            },
        },

        render() {
            return this.$scopedSlots.default({
                handler: this.handler,
            })
        },
    }
</script>
