import SiteInfoService from "./services/SiteInfoService";
import { constants } from "./helpers/constants";

export default function initApp() {
    return new Promise((resolve, reject) => {
        SiteInfoService.getSiteInfo()
            .then(response => {
                const [data] = response.data;

                Object.keys(constants).forEach(key => {
                    constants[key] = data[key];
                });
                
                document.title = constants.webSiteName;

                resolve();
            })
            .catch(error => {
                console.error("Falha ao carregar as constantes", error);
                reject(error);
            });
    });
}