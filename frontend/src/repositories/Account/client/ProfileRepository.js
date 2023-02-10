import * as Request from "../../../services/request";

export default class ProfileRepository {
  static async getUser() {
    return await Request.make("get", "/users");
  }
}
