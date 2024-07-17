import AuthService from "@/services/AuthService";
import { alertStore } from "@/store/alertStore";
import router from "@/router";

export function showError(error) {
    console.error('ERROR', error);

    if(error.response.status && error.response.status === 401) {
        if(error.response.data.invalidToken) {
            alertStore.addAlert('error', error.response.data.invalidToken);
            AuthService.logout();
            if(router) {
                router.push('/login');
            }
            
            return;
        }

        if(error.response.data.expiredToken) {
            alertStore.addAlert('error', error.response.data.expiredToken);
            AuthService.logout();
            if(router) {
                router.push('/login');
            }

            return;
        }

        if(error.response.data.invalidPermission) {
            alertStore.addAlert('error', error.response.data.invalidPermission);
            AuthService.logout();
            if(router) {
                router.push('/login');
            }

            return;
        }

        alertStore.addAlert('error', error.response.data.message);
        return;
    }

    if(error.response.status && error.response.status === 403) {
        if(error.response.data.invalidPermission) {
            alertStore.addAlert('error', error.response.data.invalidPermission);
            AuthService.logout();
            router.push('/login');
            return;
        }
    }

    if(error.response.status === 500) {
        alertStore.addAlert('error', error.response.data.message);
        return;
    }

    alertStore.addAlert('error', 'Oops, houve um erro tente novamente.');
}