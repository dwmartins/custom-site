import axios from '@/http';

class AuthService {
    getUserLogged() {
        const user = localStorage.getItem('userData');
        return user ? JSON.parse(user) : null;
    }

    setUserLogged(userData) {
        localStorage.setItem('userData', JSON.stringify(userData));
    }

    updateUserLogged(userData) {
        localStorage.removeItem('userData');
        this.setUserLogged(userData);
    }

    auth() {
        const user = this.getUserLogged();

        if(!user) {
            const error = new Error('Token não fornecido, realize o login.');
            error.statusCode = 401;
            return Promise.reject(error);
        }

        return axios.get('/users/auth', {
            headers: {
                'Authorization': `Bearer ${user.token}`,
                'userId': user.id
            }
        });
    }

    login(credentials) {
        return axios.post('/users/login', credentials);
    }

    logout() {
        localStorage.removeItem('userData');
    }
}

export default new AuthService();
