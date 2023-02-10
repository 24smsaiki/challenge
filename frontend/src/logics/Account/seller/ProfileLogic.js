import ProfileRepository from "../../../repositories/Account/seller/ProfileRepository";

export default class ProfileLogic {
  static async getSeller() {
    return await ProfileRepository.getSeller();
  }
}