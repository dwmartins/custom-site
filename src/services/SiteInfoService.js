import axios from '@/http';
import AuthService from './AuthService';
import { showError } from '@/helpers/showError';

class SiteInfoService {
    async getSiteInfo() {
        return  await axios.get('/siteinfo');
    }

    async updateImages(images) {
        const user = AuthService.validateLoggedUser();
        if (!user) return false;

        const formData = new FormData();

        for (let key in images) {
            if (images[key] !== null) {
                formData.append(key, images[key]);
            }
        }

        try {
            const response = await axios.post('/siteinfo/updateimages', formData, {
                headers: {
                  'Authorization': `Bearer userId:${user.id} token:${user.token}`,
                  'Content-Type': 'multipart/form-data'
                }
            });

            return response;
        } catch (error) {
            showError(error);
            throw error;
        }
    }

    async updateBasicInfos(infos) {
        const user = AuthService.validateLoggedUser();
        if (!user) return false;

        try {
            const response = await axios.post('/siteinfo', infos, {
                headers: {
                    'Authorization': `Bearer userId:${user.id} token:${user.token}`,
                }
            });

            return response;

        } catch (error) {
            showError(error);
            throw error;
        }
    }
}

export default new SiteInfoService();
