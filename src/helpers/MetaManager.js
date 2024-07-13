import { siteInfoStore } from "@/store/siteInfoStore";

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
        if(siteInfoStore.constants.ico) {
            let link = document.createElement('link');
            link.setAttribute('rel', 'icon');
            link.setAttribute('href', `${this.API_URL}/uploads/systemImages/${siteInfoStore.constants.ico}`);
            document.head.appendChild(link);
        }
    }

    setTitle() {
        if(siteInfoStore.constants.webSiteName) {
            document.title = siteInfoStore.constants.webSiteName;
        }
    }

    setMeta() {
        if(siteInfoStore.constants.description) {
            let metaTag = document.createElement('meta');
            metaTag.setAttribute('name', 'description');
            metaTag.setAttribute('content', siteInfoStore.constants.description);
            document.head.appendChild(metaTag); 
        }

        if(siteInfoStore.constants.keywords) {
            let metaTag = document.createElement('meta');
            metaTag.setAttribute('name', 'keywords');
            metaTag.setAttribute('content', siteInfoStore.constants.keywords);
            document.head.appendChild(metaTag); 
        }

        let metaTag = document.createElement('meta');
        metaTag.setAttribute('name', 'author');
        metaTag.setAttribute('content', 'Dwmcode Desenvolvimento de sites e otimizações - www.dwmcode.com');
        document.head.appendChild(metaTag); 
    }
}

export default new MetaManager();