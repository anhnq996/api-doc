import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
import JsonViewer from 'vue-json-viewer'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(VueSidebarMenu)
            .use(JsonViewer)
            .mount(el)
    },
})
