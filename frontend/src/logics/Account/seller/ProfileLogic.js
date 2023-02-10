import ProfileRepository from "../../../repositories/Account/seller/ProfileRepository";

export default class ProfileLogic {
  static async getSellerInformation() {
    return await ProfileRepository.getSellerInformation();
  }

  static async getShopInformation() {
    return await ProfileRepository.getShopInformation();
  }
}