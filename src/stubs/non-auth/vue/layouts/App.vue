<template>
    <div>
        <header>
            <InertiaLink href="/">
                {{ $page.app.name }}
            </InertiaLink>
        </header>

        <p v-if="$page.session.message">
            {{ $page.session.message }}
        </p>

        <main>
            <slot />
        </main>
    </div>
</template>
