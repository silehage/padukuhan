
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';

import { Quasar } from 'quasar'

import AuthLayout from './layouts/AuthLayout.vue';
import AppLayout from './layouts/AppLayout.vue';
import AppHeader from './components/Header.vue';
import AppPagination from './components/Pagination.vue';
// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'

// import iconSet from 'quasar/icon-set/material-symbols-outlined'

// Import Quasar css
import 'quasar/src/css/index.sass'
import '../css/app.scss';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: async (name) => {
      const module = await resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue'))
      if (name.startsWith('auth')) {
          module.default.layout = AuthLayout
        } 
        // console.log(module);
        
        module.default.layout = module.default.layout || AppLayout
      return module
   },
    // resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Quasar, {
                // iconSet: iconSet,
                plugins: {}, // import Quasar plugins and add here
            })
            .component('AppHeader', AppHeader)
            .component('AppPagination', AppPagination)
            .mount(el);
    },
    progress: {
        color: '#e73838',
    },
});
