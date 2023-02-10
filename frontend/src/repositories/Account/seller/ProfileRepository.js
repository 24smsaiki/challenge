import * as Request from "../../../services/request";

export default class ProfileRepository {
  static async getSellerInformation() {
    return await Request.make("get", "/users");
  }

  static async getShopInformation() {
    return await Request.make("get", "/sellers");
  }
}