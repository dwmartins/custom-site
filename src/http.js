import axios from "axios";

if(process.env.NODE_ENV === "development") {
    console.log('Estamos em modo de desenvolvimento!');
}

axios.defaults.baseURL = process.env.VUE_APP_API_URL;

export default axios;