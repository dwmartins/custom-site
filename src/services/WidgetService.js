import axios from '@/http';
// import AuthService from './AuthService';
import { showError } from '@/helpers/showError';

class WidgetService {
    async getWidgets() {
        try {
            return await axios.get('/widgets');
        } catch (error) {
            showError(error);
            throw error;
        }
    }
}

export default new WidgetService();