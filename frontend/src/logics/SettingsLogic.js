import SettingsRepository from "../repositories/SettingsRepository";

export default class SettingsLogic {
  static async getUserInformation() {
    return await SettingsRepository.getUserInformation();
  }

  static async updateUserInformation(body) {
    return await SettingsRepository.updateUserInformation(body);
  }
}
