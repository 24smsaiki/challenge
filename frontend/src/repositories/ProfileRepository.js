import * as Request from "../services/request";

export default class ProfileRepository {
  static async getUserInformation(id) {
    return await Request.make("get", `/users/${id}`);
  }

  static async getShopInformation() {
    return await Request.make("get", `/sellers`);
  }
}
