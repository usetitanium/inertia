import React, { useState } from 'react'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-react'

import App from '@/layouts/App'
import Button from '@/components/Button'
import TextField from '@/components/TextField'

const ResetPassword = () => {
    const { errors = {}, token, email } = usePage()

    const [form, setForm] = useState({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    })

    const onSubmit = event => {
        event.preventDefault()
        Inertia.post(route('password.update'), form)
    }
    const onChange = (key, value) => setForm({ ...form, [key]: value })

    return (
        <App>
            <h1>Reset password</h1>

            <form onSubmit={onSubmit}>
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

                <Button type="submit">Reset Password</Button>
            </form>
        </App>
    )
}

export default ResetPassword
