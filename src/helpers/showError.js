import AuthService from "@/services/AuthService";
import { ElNotification } from 'element-plus'
import router from "@/router";

export function showError(error) {
    console.error('ERROR', error);

    if(error.response.status && error.response.status === 401) {
        if(error.response.data.invalidToken) {
            showAlert('error', 'Erro', error.response.data.invalidToken);

            AuthService.logout();
            if(router) {
                router.push('/login');
            }
            
            return;
        }

        if(error.response.data.expiredToken) {
            showAlert('error', 'Erro', error.response.data.expiredToken);

            AuthService.logout();
            if(router) {
                router.push('/login');
            }

            return;
        }

        if(error.response.data.invalidPermission) {
            showAlert('error', 'Erro', error.response.data.invalidPermission);

            AuthService.logout();
            if(router) {
                router.push('/login');
            }

            return;
        }

        showAlert('error', 'Erro', error.response.data.message);

        return;
    }

    if(error.response.status && error.response.status === 400) {
        showAlert('error', 'Invalido', error.response.data.message);
        return;
    }

    if(error.response.status && error.response.status === 409) {
        showAlert('error', 'Invalido', error.response.data.message);
        return;
    }

    if(error.response.status && error.response.status === 403) {
        if(error.response.data.invalidPermission) {
            showAlert('error', 'Erro', error.response.data.invalidPermission);
            
            AuthService.logout();
            router.push('/login');
            return;
        }
    }

    if(error.response.status === 500) {
        showAlert('error', 'Erro', error.response.data.message);
        return;
    }

    showAlert('error', 'Oops, houve um erro tente novamente.');
}

function showAlert(type, title, message) {
    ElNotification({
        title: title,
        message: message,
        type: type,
    });
}