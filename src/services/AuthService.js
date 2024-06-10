import axios from '@/http';
import router from '@/router';

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

    login(credentials) {
        return axios.post('/login', credentials);
    }

    logout() {
        localStorage.removeItem('userData');
        router.push({name: 'Home'});
    }
}

export default new AuthService();
