import React, { useState } from 'react'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-react'

import App from '@/layouts/App'
import Button from '@/components/Button'
import TextField from '@/components/TextField'

const ForgotPassword = () => {
    const { errors = {}, session = {} } = usePage()
    const [form, setForm] = useState({ email: '' })
    const onSubmit = event => {
        event.preventDefault()
        Inertia.post(route('password.email'), form)
    }

    return (
        <App>
            <h1>Reset Password</h1>

            {session.status && <p>{session.status}</p>}

            <form onSubmit={onSubmit}>
                <TextField
                    value={form.email}
                    onChange={value => setForm({ ...form, email: value })}
                    errors={errors.email}
                    type="email"
                    label="Email"
                    autoComplete="email"
                    autoFocus
                    required
                />

                <Button type="submit">Send Password Reset Link</Button>
            </form>
        </App>
    )
}

export default ForgotPassword
