import SiteInfoService from "./services/SiteInfoService";
import { siteInfoStore } from "./store/siteInfoStore";
import AuthService from "./services/AuthService";

export default function initApp() {
    return new Promise((resolve, reject) => {
        SiteInfoService.getSiteInfo()
            .then(response => {
                const [data] = response.data;
                siteInfoStore.updateConstants(data);
                AuthService.setUserStore();

                resolve();
            })
            .catch(error => {
                console.error("Falha ao carregar as constantes", error);
                reject(error);
            });
    });
}