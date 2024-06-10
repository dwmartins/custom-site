import axios from '@/http';

class SiteInfoService {
    async getSiteInfo() {
        return  await axios.get('/siteinfo/fetch');
    }
}

export default new SiteInfoService();
