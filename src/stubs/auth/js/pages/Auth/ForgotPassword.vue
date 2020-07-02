<template>
    <App>
        <h1>Reset Password</h1>

        <p v-if="$page.session.status">
            {{ $page.session.status }}
        </p>

        <form @submit.prevent="submit">
            <TextField
                v-model="form.email"
                :errors="$page.errors.email"
                type="email"
                label="Email"
                autocomplete="email"
                autofocus
                required
            />

            <Button type="submit">
                Send Password Reset Link
            </Button>
        </form>
    </App>
</template>

<script>
    import TextField from '@/components/TextField'
    import Button from '@/components/Button'
    import App from '@/layouts/App'

    export default {
        components: {
            TextField,
            Button,
            App,
        },

        data() {
            return {
                form: {
                    email: '',
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('password.email'), this.form)
            },
        },
    }
</script>
