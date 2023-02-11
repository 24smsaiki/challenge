import ProfileRepository from "../../../repositories/Account/seller/ProfileRepository";

export default class ProfileLogic {
  static async getSellerInformation(id) {
    return await ProfileRepository.getSellerInformation(id);
  }

  static async getShopInformation() {
    return await ProfileRepository.getShopInformation();
  }
}
