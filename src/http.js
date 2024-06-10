import axios from "axios";

if(process.env.NODE_ENV === "development") {
    console.log('Estamos em modo de desenvolvimento!');
    axios.defaults.baseURL = 'http://localhost/test-vuejs/api';
} else {
    axios.defaults.baseURL = 'https://dufon.dwmcode.com/api';
}

export default axios;