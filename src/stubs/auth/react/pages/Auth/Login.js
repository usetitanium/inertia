import React, { useState } from 'react'
import { Inertia } from '@inertiajs/inertia'
import { usePage, InertiaLink } from '@inertiajs/inertia-react'

import App from '@/layouts/App'
import Button from '@/components/Button'
import TextField from '@/components/TextField'
import CheckboxField from '@/components/CheckboxField'

const Login = () => {
    const { errors = {} } = usePage()
    const [form, setForm] = useState({
        email: '',
        password: '',
        remember: false,
    })
    const onSubmit = event => {
        event.preventDefault()
        Inertia.post(route('login'), form)
    }
    const onChange = (key, value) => setForm({ ...form, [key]: value })

    return (
        <App>
            <h1>Login</h1>

            <form onSubmit={onSubmit}>
                <TextField
                    value={form.email}
                    onChange={value => onChange('email', value)}
                    errors={errors.email}
                    type="email"
                    label="Email"
                    autoComplete="email"
                    autoFocus
                    required
                />
                <TextField
                    value={form.password}
                    onChange={value => onChange('password', value)}
                    errors={errors.email}
                    type="password"
                    label="Password"
                    autoComplete="current-password"
                    required
                />
                <CheckboxField
                    value={form.remember}
                    onChange={value => onChange('remember', value)}
                    label="Remember me"
                />
                <Button type="submit">Login</Button>
            </form>

            <div>
                <InertiaLink href={route('password.request')}>
                    Forgot password?
                </InertiaLink>
                <InertiaLink href={route('register')}>
                    Don't have an account yet?
                </InertiaLink>
            </div>
        </App>
    )
}

export default Login
