import * as Request from "../services/request";

export default class AuthRepository {
  static async login({ email, password }) {
    return await Request.make("post", "/auth", { email, password });
  }

  static async register(body) {
    return await Request.make("post", "/register", { ...body });
  }

  static async registerSeller(body) {
    return await Request.make("post", "/sellers", { ...body });
  }
}
