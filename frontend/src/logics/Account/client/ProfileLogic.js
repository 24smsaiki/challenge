import ProfileRepository from "../../../repositories/Account/client/ProfileRepository";

export default class ProfileLogic {
  static async getUserInformation(id) {
    return await ProfileRepository.getUserInformation(id);
  }
}
