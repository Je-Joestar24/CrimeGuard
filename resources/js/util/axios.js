import Axios from "axios";

const axios = Axios.create({
    baseURL: "https://crime-guard.csitcicte.com/",
    timeout: 30000,
    headers: {
        Accept: "application/json",
    }
});

// Intercept the request to include the Authorization header with the token
axios.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, (error) => {
    return Promise.reject(error);
});

export default axios;
