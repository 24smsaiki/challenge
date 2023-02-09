import ProfileRepository from "../../repositories/Account/ProfileRepository";

export default class ProfileLogic {
  static async getUser() {
    return await ProfileRepository.getUser();
  }
}
