import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

const api  = axios.create({
    baseURL : '/api',
    // baseURL : 'http://172.31.76.43:8000/api',
   
});

export default api;
