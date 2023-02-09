import SettingsRepository from "../../repositories/Account/SettingsRepository";

export default class SettingsLogic {
  static async getUser() {
    return await SettingsRepository.getUser();
  }

  static async updateUser(id, body) {
    return await SettingsRepository.updateUser(id, body);
  }
}
