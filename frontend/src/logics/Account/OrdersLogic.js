import OrdersRepository from "../../repositories/Account/OrdersRepository";

export default class OrdersLogic {
  static async getOrders() {
    return await OrdersRepository.getOrders();
  }
}
