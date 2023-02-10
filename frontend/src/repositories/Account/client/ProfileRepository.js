import * as Request from "../../../services/request";

export default class ProfileRepository {
  static async getUserInformation() {
    return await Request.make("get", "/users");
  }
}
