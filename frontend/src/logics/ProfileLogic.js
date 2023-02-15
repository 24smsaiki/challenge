import ProfileRepository from "../repositories/ProfileRepository";

export default class ProfileLogic {
  static async getUserInformation(id) {
    return await ProfileRepository.getUserInformation(id);
  }

  static async getShopInformation(id) {
    return await ProfileRepository.getShopInformation(id);
  }
}
