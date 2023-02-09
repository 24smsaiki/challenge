import ProfileRepository from "../repositories/ProfileRepository";

export default class ProfileLogic {
  static async getUser() {
    return await ProfileRepository.getUser();
  }
}
