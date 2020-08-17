import React from 'react'
import { usePage } from '@inertiajs/inertia-react'

import App from '@/layouts/App'
import Post from '@/components/Post'

const VerifyEmail = () => {
    const { session = {} } = usePage()

    return (
        <App>
            <h1>Verify Email</h1>

            {session.resent && (
                <p>
                    A fresh verification link has been sent to your email
                    address.
                </p>
            )}

            <p>
                Before proceeding, please check your email for a verification
                link.
            </p>

            <p>
                If you did not receive the email,
                <Post
                    to={route('verification.resend')}
                    render={({ handler }) => (
                        <a
                            href={route('verification.resend')}
                            onClick={event => {
                                event.preventDefault()
                                handler()
                            }}
                        >
                            Logout
                        </a>
                    )}
                />
            </p>
        </App>
    )
}

export default VerifyEmail
