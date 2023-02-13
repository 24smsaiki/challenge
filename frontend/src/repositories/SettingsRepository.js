import * as Request from "../services/request";

export default class OrdersRepository {
  static async getUserInformation(id) {
    return await Request.make("get", `/users/${id}`);
  }

  static async updateUserInformation(body) {
    return await Request.make("post", "/users/updateprofile", { ...body });
  }

  static async updateShopInformation(id, body) {
    return await Request.make("put", `/sellers/${id}`, { ...body });
  }

  static async getShopInformation() {
    return await Request.make("get", "/sellers");
  }
}
