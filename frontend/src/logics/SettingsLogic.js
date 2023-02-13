import SettingsRepository from "../repositories/SettingsRepository";

export default class SettingsLogic {
  static async getUserInformation(id) {
    return await SettingsRepository.getUserInformation(id);
  }

  static async updateUserInformation(body) {
    return await SettingsRepository.updateUserInformation(body);
  }

  static async updateShopInformation(id, body) {
    return await SettingsRepository.updateShopInformation(id, body);
  }

  static async getShopInformation() {
    return await SettingsRepository.getShopInformation();
  }
}
