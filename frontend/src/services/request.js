import LocalStorage from "./localStorage";
import axios from "axios";
import router from "../router/Router";

const request = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

request.interceptors.request.use((config) => {
  const token = LocalStorage.get("token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  } else {
    localStorage.removeItem("app-token");
    localStorage.removeItem("app-user");
    router.push({ name: "Login" });
    window.location.reload();
  }

  return config;
});

export default request;

export const make = async (method, url, data) => {
  const config = {
    method,
    url,
    data,
  };
  return await request(config);
};
