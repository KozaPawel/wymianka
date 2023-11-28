import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy'
import Navbar from '@/Layouts/Navbar.vue'
import '../css/app.css'

createInertiaApp({
    progress: { color: '#305d42' },
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const page = (await pages[`./Pages/${name}.vue`])
        page.default.layout = page.default.layout || Navbar

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
})
