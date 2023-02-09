import AuthRepository from "../repositories/AuthRepository";
import LocalStorage from "../services/LocalStorage";
import jwt_decode from "jwt-decode";

export default class AuthLogic {
  static async register(body) {
    const result = await AuthRepository.register(body);
    return result.message;
  }

  static async login(body) {
    await AuthRepository.login({ ...body }).then((res) => {
      const result = jwt_decode(res.data.token);

      AuthLogic.setToken(res.data.token);
      AuthLogic.setStorageUser(result);

      return result;
    });
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
    let token = LocalStorage.get("token");
    delete token.refresh_token;
    AuthLogic.settoken(token);
  }

  static setStorageUser(user) {
    LocalStorage.set("user", user);
  }
}
