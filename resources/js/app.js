import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// Oruga UI
import Oruga from '@oruga-ui/oruga-next';
import '@oruga-ui/oruga-next/dist/oruga.css';
import '@oruga-ui/oruga-next/dist/oruga-full.css';
import '@oruga-ui/oruga-next/dist/oruga-full-vars.css';

// CKEditor
import CKEditor from '@ckeditor/ckeditor5-vue';

// Material Design icons
import '@mdi/font/css/materialdesignicons.min.css';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Oruga)
            .use(CKEditor)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#FF0000',
    },
});
