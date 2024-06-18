import { store } from "@/store/siteInfoStore";

class MetaManager {
    API_URL;

    constructor() {
        this.API_URL = process.env.VUE_APP_API_URL;
    }

    setAllMeta() {
        this.setIcon();
        this.setTitle();
        this.setMeta();
    }

    setIcon() {
        if(store.state.constants.icon) {
            let link = document.createElement('link');
            link.setAttribute('rel', 'icon');
            link.setAttribute('href', `${this.API_URL}/uploads/site/${store.state.constants.icon}`);
            document.head.appendChild(link);
        }
    }

    setTitle() {
        if(store.state.constants.webSiteName) {
            document.title = store.state.constants.webSiteName;
        }
    }

    setMeta() {
        if(store.state.constants.description) {
            let metaTag = document.createElement('meta');
            metaTag.setAttribute('name', 'description');
            metaTag.setAttribute('content', store.state.constants.description);
            document.head.appendChild(metaTag); 
        }

        if(store.state.constants.keywords) {
            let metaTag = document.createElement('meta');
            metaTag.setAttribute('name', 'keywords');
            metaTag.setAttribute('content', store.state.constants.keywords);
            document.head.appendChild(metaTag); 
        }

        let metaTag = document.createElement('meta');
        metaTag.setAttribute('name', 'author');
        metaTag.setAttribute('content', 'Dwmcode Desenvolvimento de sites e otimizações - www.dwmcode.com');
        document.head.appendChild(metaTag); 
    }
}

export default new MetaManager();