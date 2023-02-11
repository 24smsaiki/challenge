import * as Request from "../services/request";

export default class OrdersRepository {
  static async getUserInformation() {
    return await Request.make("get", "/users");
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
