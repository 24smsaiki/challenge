import * as Request from "../../../services/request";

export default class OrdersRepository {
  static async getUserInformation() {
    return await Request.make("get", "/users");
  }

  static async updateUserInformation(body) {
    return await Request.make("post", "/users/updateprofile", { ...body });
  }
}
