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

    async newUser(userData) {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.post('/user', userData, {
                headers: {
                    'Authorization': AuthService.getBearer()
                }
            })
        } catch (error) {
            showError(error);
            throw error;
        }
    }

    async deleteUser(userId) {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.delete(`/user/${userId}`, {
                headers: {
                    'Authorization': AuthService.getBearer()
                }
            });
        } catch (error) {
            showError(error);
            throw error;
        }
    }

    async deleteMultiples(ids) {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.post(`/user/delete-multiples`, ids,{
                headers: {
                    'Authorization': AuthService.getBearer()
                }
            })
        } catch (error) {
            showError(error);
            throw error;
        }
    }

    async updateUser(userData) {
        const user = AuthService.validateLoggedUser();
        if(!user) return false;

        try {
            return await axios.put(`/user/`, userData,{
                headers: {
                    'Authorization': AuthService.getBearer()
                }
            }) 
        } catch (error) {
            showError(error);
            throw error;
        }
    }
}

export default new UserService();
