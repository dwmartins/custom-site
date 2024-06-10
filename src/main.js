import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import http from './http';
import initApp from './initApp';

initApp().then(() => {
    const app = createApp(App);
    app.use(router);
    app.mount('#app');
    app.config.globalProperties.$http = http;
});

