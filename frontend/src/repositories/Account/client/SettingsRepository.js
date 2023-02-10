import * as Request from "../../../services/request";

export default class OrdersRepository {
  static async getUser() {
    return await Request.make("get", "/users");
  }

  static async updateUser(id, body) {
    return await Request.make("put", `/users/${id}`, { ...body });
  }
}
