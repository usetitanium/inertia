<template>
    <App>
        <h1>Register</h1>

        <form @submit.prevent="submit">
            <TextField
                v-model="form.name"
                :errors="$page.errors.name"
                type="text"
                label="Name"
                autocomplete="name"
                autofocus
                required
            />
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
                Register
            </Button>
        </form>

        <div>
            <InertiaLink :href="route('login')">
                Already have an account?
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
            App,
        },

        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('register'), this.form)
            },
        },
    }
</script>
