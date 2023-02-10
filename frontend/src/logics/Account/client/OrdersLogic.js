import OrdersRepository from "../../../repositories/Account/client/OrdersRepository";

export default class OrdersLogic {
  static async getOrders() {
    return await OrdersRepository.getOrders();
  }
}
