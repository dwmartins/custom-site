import axios from '@/http';
import AuthService from './AuthService';
import { showError } from '@/helpers/showError';

class UserService {
    async getUsers() {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.get('/user', {
                headers: {
                    'Authorization': AuthService.getBearer()
                }
            });
        } catch (error) {
            showError(error);
            throw error;
        }
    }
}

export default new UserService();
