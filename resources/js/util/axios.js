import Axios from "axios";

const axios = Axios.create({
    baseURL: "http://127.0.0.1:8000",
    timeout: 30000,
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
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
