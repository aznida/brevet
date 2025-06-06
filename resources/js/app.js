import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
    //set mixins
    .mixin({
        methods: {

          examTimeRangeChecker: function (start_time, end_time) {
            return new Date() >= new Date(start_time) && new Date() <= new Date(end_time)
          },

          examTimeStartChecker: function (start_time) {
            return new Date() < new Date(start_time)
          },

          examTimeEndChecker: function (end_time) {
            return new Date() > new Date(end_time)
          }

        },
    })
    .use(plugin)
    .mount(el)
  },
  progress: {
    // The delay after which the progress bar will appear, in milliseconds...
    delay: 250,

    // The color of the progress bar...
    color: '#29d',

    // Whether to include the default NProgress styles...
    includeCSS: true,

    // Whether the NProgress spinner will be shown...
    showSpinner: false,
  },
})

// Register service worker for offline support
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js')
      .then(registration => {
        console.log('Service Worker registered with scope:', registration.scope);
      })
      .catch(error => {
        console.error('Service Worker registration failed:', error);
      });
  });
}