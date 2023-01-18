import LocalStorage from "../services/LocalStorage";
import AuthRepository from "../repositories/AuthRepository";
import jwt_decode from "jwt-decode";

export default class AuthLogic {

    static async register(body) {
        const result = await AuthRepository.register(body);
        if (result.response.status === 422) {
            
            const errors = result.response.data;
            const errorsArray = Object.values(errors);
            throw new Error(errorsArray);
        }
        return result.response.data;
    }

    static async login(body) {
        const result = await AuthRepository.login({...body});
        
        const res = jwt_decode(result.token);
        
        AuthLogic.setToken(result.token);
        AuthLogic.setStorageUser(res);
        return res;
        
    }

    static logout() {
        this.clear();
    }

    static isAuth() {
        return !!this.getToken();
    }

        
    static getToken() {
        return LocalStorage.get("token");
    }
    
    static setToken(token) {
        LocalStorage.set("token", token);
    }
    
    static removetoken() {
        LocalStorage.remove("token");
    }
    
    static clear() {
        LocalStorage.clear();
    }
    static async refreshToken(refreshToken) {
        this.deleteRefreshToken();
        const response = await AuthRepository.refresh(refreshToken);
        AuthLogic.setToken(response.responseObject());
        return response.responseObject();
    }

    static deleteRefreshToken() {
        let token = LocalStorage.get("token")
        delete token.refresh_token
        AuthLogic.settoken(token)
      }

    static setStorageUser(user) {
        LocalStorage.set("user", user);
    }
    }