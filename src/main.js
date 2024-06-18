import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import initApp from './initApp';
import 'bootstrap/dist/css/bootstrap.min.css'; 
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import MetaManager from './helpers/MetaManager';
import { store } from '@/store/userStore';
import '@/assets/css/global.css';

initApp().then(() => {
    const app = createApp(App);
    app.use(router);
    app.use(store);
    app.mount('#app');

    app.config.globalProperties.$API_URL = process.env.VUE_APP_API_URL;
    MetaManager.setAllMeta()
});

