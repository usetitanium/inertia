import Vue from 'vue'
import { InertiaApp } from '@inertiajs/inertia-vue'

import unqiueUuid from '@/mixins/uniqueUuid'

Vue.use(InertiaApp)

Vue.mixin(unqiueUuid)
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
