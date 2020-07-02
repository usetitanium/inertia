<template>
    <div>
        <header>
            <InertiaLink :href="route('home')">
                {{ $page.app.name }}
            </InertiaLink>

            <nav>
                <InertiaLink v-if="!authenticated" :href="route('login')">
                    Login
                </InertiaLink>
                <InertiaLink v-if="!authenticated" :href="route('register')">
                    Register
                </InertiaLink>
                <Post
                    v-if="authenticated"
                    :to="route('logout')"
                    #default="{ handler }"
                >
                    <a :href="route('logout')" @click.prevent="handler">
                        Logout
                    </a>
                </Post>
            </nav>
        </header>

        <p v-if="$page.session.verified">
            Your email has been verified.
        </p>

        <p v-if="$page.session.message">
            {{ $page.session.message }}
        </p>

        <main>
            <slot />
        </main>
    </div>
</template>

<script>
    import Post from '@/components/Post'

    export default {
        components: {
            Post,
        },

        computed: {
            authenticated() {
                return !!this.$page.auth.user
            },
        },
    }
</script>
