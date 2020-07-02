<template>
    <App>
        <h1>Login</h1>

        <form @submit.prevent="submit">
            <TextField
                v-model="form.email"
                type="email"
                label="Email"
                autocomplete="email"
                autofocus
                required
            />
            <TextField
                v-model="form.password"
                :errors="$page.errors.email"
                type="password"
                label="Password"
                autocomplete="current-password"
                required
            />
            <CheckboxField v-model="form.remember" label="Remember me" />
            <Button type="submit">
                Login
            </Button>
        </form>

        <div>
            <InertiaLink :href="route('password.request')">
                Forgot password?
            </InertiaLink>
            <InertiaLink :href="route('register')">
                Don't have an account yet?
            </InertiaLink>
        </div>
    </App>
</template>

<script>
    import CheckboxField from '@/components/CheckboxField'
    import TextField from '@/components/TextField'
    import Button from '@/components/Button'
    import App from '@/layouts/App'

    export default {
        components: {
            CheckboxField,
            TextField,
            Button,
            App,
        },

        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    remember: false,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('login'), this.form)
            },
        },
    }
</script>
