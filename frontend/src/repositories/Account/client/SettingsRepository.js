import * as Request from "../../../services/request";

export default class OrdersRepository {
  static async getUserInformation() {
    return await Request.make("get", "/users");
  }

  static async updateUserInformation(id, body) {
    return await Request.make("put", `/users/${id}`, { ...body });
  }
}
