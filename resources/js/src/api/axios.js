import axios from "axios";
import getCookie from "@/helpers/getCookie.js";

// const secureCookie = document.querySelector('meta[name="secure-cookie"]').content === 'true';

// axios.defaults.baseURL = `${secureCookie ? 'https' : 'http'}://${window.location.host}`;
axios.defaults.baseURL =`https://${window.location.host}`;

axios.defaults.withCredentials = true;

axios.interceptors.request.use(config => {
    const token = getCookie('X-XSRF-TOKEN');
    if (token) {
        config.headers['X-XSRF-TOKEN'] = decodeURIComponent(token);
    } else {
        config.headers['X-XSRF-TOKEN'] = '';
    }
    return config;
});

axios.interceptors.request.use(config => {

    config.headers['Accept-Language'] = localStorage.getItem('locale') || 'ru';

    return config;
}, error => {
    return Promise.reject(error);
});

export default axios
