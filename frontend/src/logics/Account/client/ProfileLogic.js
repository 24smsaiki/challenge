import ProfileRepository from "../../../repositories/Account/client/ProfileRepository";

export default class ProfileLogic {
  static async getUser() {
    return await ProfileRepository.getUser();
  }
}
