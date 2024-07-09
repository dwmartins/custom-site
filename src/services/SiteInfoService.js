import axios from '@/http';

class SiteInfoService {
    async getSiteInfo() {
        return  await axios.get('/siteinfo');
    }
}

export default new SiteInfoService();
