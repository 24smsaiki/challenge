import * as Request from "../services/request";

export default class UsersRepository {
  static async getUsers() {
    return await Request.make("get", "/users");
  }

  static async getUser(id) {
    return await Request.make("get", `/users/${id}`);
  }

  static async createUser(body) {
    return await Request.make("post", "/users", { ...body });
  }

  static async updateUser(id, body) {
    return await Request.make("put", `/users/${id}`, { ...body });
  }

  static async deleteUser(id) {
    return await Request.make("delete", `/users/${id}`);
  }

  static async getSellers() {
    return await Request.make("get", "/sellers");
  }

  static async getRequestSellers(idSeller) {
    return await Request.make(
      "post",
      `https://localhost/seller/${idSeller}/request/answer`
    );
  }
}
