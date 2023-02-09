import AddressesRepository from "../repositories/AddressesRepository";

export default class AddressesLogic {
  static async getAddresses() {
    return await AddressesRepository.getAddresses();
  }

  static async getAddress(id) {
    return await AddressesRepository.getAddress(id);
  }

  static async createAddress(body) {
    return await AddressesRepository.createAddress(body);
  }

  static async updateAddress(id, body) {
    return await AddressesRepository.updateAddress(id, body);
  }
}
