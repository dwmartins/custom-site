import axios from '@/http';
// import AuthService from './AuthService';
import { showError } from '@/helpers/showError';
import AuthService from './AuthService';

class WidgetService {
    async getWidgets() {
        try {
            return await axios.get('/widgets');
        } catch (error) {
            showError(error);
            throw error;
        }
    }

    async saveWIdget(widget) {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.post('/widgets/floatingButton', widget, {
                headers: {
                    'Authorization': `Bearer userId:${user.id} token:${user.token}`,
                }
            });
        } catch (error) {
            showError(error);
            throw error;
        }
    }
}

export default new WidgetService();