import React, { useState } from 'react'
import { Inertia } from '@inertiajs/inertia'
import { usePage, InertiaLink } from '@inertiajs/inertia-react'

import App from '@/layouts/App'
import Button from '@/components/Button'
import TextField from '@/components/TextField'

const Register = () => {
    const { errors = {} } = usePage()
    const [form, setForm] = useState({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    })
    const onSubmit = event => {
        event.preventDefault()
        Inertia.post(route('register'), form)
    }
    const onChange = (key, value) => setForm({ ...form, [key]: value })

    return (
        <App>
            <h1>Register</h1>

            <form onSubmit={onSubmit}>
                <TextField
                    value={form.name}
                    onChange={value => onChange('name', value)}
                    errors={errors.name}
                    type="text"
                    label="Name"
                    autoComplete="name"
                    autoFocus
                    required
                />
                <TextField
                    value={form.email}
                    onChange={value => onChange('email', value)}
                    errors={errors.email}
                    type="email"
                    label="Email"
                    autoComplete="email"
                    required
                />
                <TextField
                    value={form.password}
                    onChange={value => onChange('password', value)}
                    errors={errors.password}
                    type="password"
                    label="Password"
                    autoComplete="new-password"
                    required
                />
                <TextField
                    value={form.password_confirmation}
                    onChange={value => onChange('password_confirmation', value)}
                    errors={errors.password_confirmation}
                    type="password"
                    label="Confirm Password"
                    autoComplete="new-password"
                    required
                />

                <Button type="submit">Register</Button>
            </form>

            <div>
                <InertiaLink href={route('login')}>
                    Already have an account?
                </InertiaLink>
            </div>
        </App>
    )
}

export default Register
