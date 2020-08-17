import React, { Fragment } from 'react'
import { usePage, InertiaLink } from '@inertiajs/inertia-react'
import Post from '@/components/Post'

const App = ({ children }) => {
    const { app, auth, session } = usePage()

    const authenticated = !!auth.user

    return (
        <div>
            <header>
                <InertiaLink href={route('home')}>{app.name}</InertiaLink>

                <nav>
                    {!authenticated && (
                        <Fragment>
                            <InertiaLink href={route('login')}>
                                Login
                            </InertiaLink>
                            <InertiaLink href={route('register')}>
                                Register
                            </InertiaLink>
                        </Fragment>
                    )}
                    {authenticated && (
                        <Post
                            to={route('logout')}
                            render={({ handler }) => (
                                <a
                                    href={route('logout')}
                                    onClick={event => {
                                        event.preventDefault()
                                        handler()
                                    }}
                                >
                                    Logout
                                </a>
                            )}
                        />
                    )}
                </nav>
            </header>

            {session.verified && <p>Your email has been verified.</p>}

            {session.message && <p>{session.message}</p>}

            <main>{children}</main>
        </div>
    )
}

export default App
