import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import initApp from './initApp';
import 'bootstrap/dist/css/bootstrap.min.css'; 
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import MetaManager from './helpers/MetaManager';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css';
import '@/assets/css/global.css';
import '@/assets/css/animations.css';

initApp().then(() => {
    const app = createApp(App);
    app.use(router);
    app.mount('#app');
    app.use(ElementPlus);

    app.config.globalProperties.$API_URL = process.env.VUE_APP_API_URL;
    
    MetaManager.setAllMeta()
});

