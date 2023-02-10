import OrdersRepository from "../../../repositories/Account/seller/OrdersRepository";

export default class OrdersLogic {
  static async getOrders() {
    return await OrdersRepository.getOrders();
  }
}
