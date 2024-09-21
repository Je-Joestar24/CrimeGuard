import Axios from "axios";

const axios = Axios.create({
    baseURL: "https://crime-guard.ap.ngrok.io",/* 127.0.0.1 http://192.168.69.147:8000*/
    timeout: 30000,
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        Accept: "application/json",
        "Content-type": "application/json",
        "Access-Control-Allow-Methods": "*",
        "Access-Control-Allow-Origin": "*",
        'Content-Type': 'multipart/form-data',
    }
})
/*  */

export default axios;