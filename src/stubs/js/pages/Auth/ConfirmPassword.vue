<template>
    <App>
        <h1>Confirm password</h1>

        <p>
            Please confirm your password before continuing.
        </p>

        <form @submit.prevent="submit">
            <TextField
                v-model="form.password"
                :errors="$page.errors.password"
                type="password"
                label="Password"
                autocomplete="current-password"
                required
                autofocus
            />

            <Button type="submit">
                Confirm Password
            </Button>
        </form>

        <div>
            <InertiaLink :href="route('password.request')">
                Forgot password?
            </InertiaLink>
        </div>
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
                    password: '',
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('password.confirm'), this.form)
            },
        },
    }
</script>
