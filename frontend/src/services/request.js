import axios from "axios";
import LocalStorage from "./localStorage";


const request = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
    },
});
console.log("request.js: ", import.meta.env.VITE_API_URL);
request.interceptors.request.use(
    (config) => {
        const token = LocalStorage.get("token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    }
);

export default request;

export const make = async(method, url, data) => {
    const config = {
        method,
        url,
        data,
    };

    try {
        const response = await request(config);
        return response.data;
    }
    catch (error) {
        throw error;
    }
};



