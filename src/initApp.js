import SiteInfoService from "./services/SiteInfoService";
import { store } from "@/store/index";

export default function initApp() {
    return new Promise((resolve, reject) => {
        SiteInfoService.getSiteInfo()
            .then(response => {
                const [data] = response.data;
                store.dispatch('updateConstants', data);

                resolve();
            })
            .catch(error => {
                console.error("Falha ao carregar as constantes", error);
                reject(error);
            });
    });
}