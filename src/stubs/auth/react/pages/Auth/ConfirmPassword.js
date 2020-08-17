import React, { useState } from 'react'
import { Inertia } from '@inertiajs/inertia'
import { usePage, InertiaLink } from '@inertiajs/inertia-react'

import App from '@/layouts/App'
import Button from '@/components/Button'
import TextField from '@/components/TextField'

const ConfirmPassword = () => {
    const { errors = {} } = usePage()
    const [form, setForm] = useState({ password: '' })
    const onSubmit = event => {
        event.preventDefault()
        Inertia.post(route('password.confirm'), form)
    }

    return (
        <App>
            <h1>Confirm password</h1>

            <p>Please confirm your password before continuing.</p>

            <form onSubmit={onSubmit}>
                <TextField
                    value={form.password}
                    onChange={value => setForm({ ...form, password: value })}
                    errors={errors.password}
                    type="password"
                    label="Password"
                    autoComplete="current-password"
                    required
                    autoFocus
                />

                <Button type="submit">Confirm Password</Button>
            </form>

            <div>
                <InertiaLink href={route('password.request')}>
                    Forgot password?
                </InertiaLink>
            </div>
        </App>
    )
}

export default ConfirmPassword
