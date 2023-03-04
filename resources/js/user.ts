require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from '@inertiajs/progress'
import Layout from "./Layouts/Layout.vue";

InertiaProgress.init({
    delay: 1000,
    color: '#29d',
    includeCSS: true,
    showSpinner: false,
});

createInertiaApp({
    
    resolve: (name) => {
        const page = require(`./Pages/${name}`).default;
        page.layout = page.layout || Layout;
        return page;
    },
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el);
    },
});