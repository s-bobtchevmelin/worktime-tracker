import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import {createPinia} from "pinia";
import axios from 'axios'


const pinia = createPinia()
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Set Axios globally
        app.config.globalProperties.$axios = axios; // Make Axios globally available

        app.use(pinia); // Use Pinia for state management
        app.use(plugin); // Use Inertia plugin
        app.use(ZiggyVue); // Use Ziggy for route management
        app.mount(el); // Mount the app
    },
    progress: {
        color: '#4B5563',
    },
});
