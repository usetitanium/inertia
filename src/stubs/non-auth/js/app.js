import Vue from 'vue'
import { InertiaApp } from '@inertiajs/inertia-vue'

Vue.use(InertiaApp)

Vue.mixin({ methods: { route: window.route } })

Vue.config.devtools = true

const app = document.getElementById('app')

new Vue({
    render: h =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name => require(`./pages/${name}`).default,
            },
        }),
}).$mount(app)
