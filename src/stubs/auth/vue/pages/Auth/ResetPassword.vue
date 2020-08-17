<template>
    <App>
        <h1>Reset password</h1>

        <form @submit.prevent="submit">
            <TextField
                v-model="form.email"
                :errors="$page.errors.email"
                type="email"
                label="Email"
                autocomplete="email"
                required
            />
            <TextField
                v-model="form.password"
                :errors="$page.errors.password"
                type="password"
                label="Password"
                autocomplete="new-password"
                required
            />
            <TextField
                v-model="form.password_confirmation"
                :errors="$page.errors.password_confirmation"
                type="password"
                label="Confirm Password"
                autocomplete="new-password"
                required
            />

            <Button type="submit">
                Reset Password
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
                    token: this.$page.token,
                    email: this.$page.email,
                    password: '',
                    password_confirmation: '',
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('password.update'), this.form)
            },
        },
    }
</script>
