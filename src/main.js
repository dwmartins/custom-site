import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import http from './http';
import initApp from './initApp';
import 'bootstrap/dist/css/bootstrap.min.css'; 
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

initApp().then(() => {
    const app = createApp(App);
    app.use(router);
    app.mount('#app');
    app.config.globalProperties.$http = http;

    if(process.env.NODE_ENV === "development") {
        app.config.globalProperties.API_URL = 'http://localhost/test-vuejs/api/';
    } else {
        app.config.globalProperties.API_URL = 'https://dufon.dwmcode.com/api/';
    }
});

