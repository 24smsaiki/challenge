import ProfileRepository from "../repositories/ProfileRepository";

export default class ProfileLogic {
  static async getUserInformation() {
    return await ProfileRepository.getUserInformation();
  }

  static async getShopInformation() {
    return await ProfileRepository.getShopInformation();
  }
}
