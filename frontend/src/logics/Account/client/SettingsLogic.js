import SettingsRepository from "../../../repositories/Account/client/SettingsRepository";

export default class SettingsLogic {
  static async getUserInformation() {
    return await SettingsRepository.getUserInformation();
  }

  static async updateUserInformation(id, body) {
    return await SettingsRepository.updateUserInformation(id, body);
  }
}
