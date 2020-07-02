<template>
    <App>
        <h1>Verify Email</h1>

        <p v-if="$page.session.resent">
            A fresh verification link has been sent to your email address.
        </p>

        <p>
            Before proceeding, please check your email for a verification link.
        </p>

        <p>
            If you did not receive the email,
            <Post :to="route('verification.resend')" #default="{ handler }">
                <a :href="route('logout')" @click.prevent="handler">
                    click here to request another.
                </a>
            </Post>
        </p>
    </App>
</template>

<script>
    import Post from '@/components/Post'
    import App from '@/layouts/App'

    export default {
        components: {
            Post,
            App,
        },
    }
</script>
