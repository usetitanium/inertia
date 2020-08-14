import React from 'react'
import { InertiaLink, usePage } from '@inertiajs/inertia-react'

const App = ({ children }) => {
    const { app, session } = usePage()

    return (
        <div>
            <header>
                <InertiaLink href="/">{app.name}</InertiaLink>
            </header>

            {session.message && <p>{session.message}</p>}

            <main>{children}</main>
        </div>
    )
}

export default App
