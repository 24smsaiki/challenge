import CarriersRepository from "../repositories/CarriersRepository";

export default class CarriersLogic {
  static async getCarriers() {
    return await CarriersRepository.getCarriers();
  }

  static async getCarrier(id) {
    return await CarriersRepository.getCarrier(id);
  }

  static async createCarrier(body) {
    return await CarriersRepository.createCarrier(body);
  }

  static async updateCarrier(id, body) {
    return await CarriersRepository.updateCarrier(id, body);
  }
}
