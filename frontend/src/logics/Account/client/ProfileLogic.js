import ProfileRepository from "../../../repositories/Account/client/ProfileRepository";

export default class ProfileLogic {
  static async getUserInformation() {
    return await ProfileRepository.getUserInformation();
  }
}
