import axios from '@/http';
import AuthService from './AuthService';
import { showError } from '@/helpers/showError';

class EmailConfigService {
    async getEmailConfig() {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.get('/emailconfig', {
                headers: {
                    'Authorization': `Bearer userId:${user.id} token:${user.token}`,
                }
            });
        } catch (error) {
            showError(error);
            throw error;
        }
    }

    async activeConfigs(configs) {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.post('/emailconfig/active', configs, {
                headers: {
                    'Authorization': `Bearer userId:${user.id} token:${user.token}`,
                }
            });
        } catch (error) {
            showError(error);
            throw error;
        }
    }

    async save(emailConfig) {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.post('/emailconfig', emailConfig, {
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

export default new EmailConfigService();