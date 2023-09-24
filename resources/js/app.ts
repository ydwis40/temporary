import './bootstrap';
import '../css/app.css';

//theme
import "primevue/resources/themes/tailwind-light/theme.css";

//core
import "primevue/resources/primevue.min.css";

import 'primeicons/primeicons.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from 'primevue/config';
import Tailwind from "primevue/passthrough/tailwind";
import ToastService from 'primevue/toastservice';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Widuri';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue, {
                ripple: true,
                pt: Tailwind
            })
            .use(ToastService)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
