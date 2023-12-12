import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import Navbar from '@/Layouts/Navbar.vue'
import '../css/app.css'

createInertiaApp({
    progress: { color: '#61ae3f' },
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const page = (await pages[`./Pages/${name}.vue`])
        if (page.default.layout === undefined) {
            page.default.layout = Navbar
        }

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, {
                position: 'top-right',
                timeout: 4000,
                closeOnClick: true,
                pauseOnFocusLoss: false,
                pauseOnHover: true,
                draggable: true,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: 'button',
                icon: false,
                rtl: false,
                transition: 'Vue-Toastification__bounce',
                maxToasts: 5,
                newestOnTop: true,
            })
            .mount(el)
    },
})
