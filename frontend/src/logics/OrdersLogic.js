import OrdersRepository from "../repositories/OrdersRepository";

export default class OrdersLogic {
  static async pass_order(body) {
    return await OrdersRepository.pass_order(body);
  }

  static async confirmOrder(id) {
    return await OrdersRepository.confirmOrder(id);
  }

  static async getOrders() {
    return await OrdersRepository.getOrders();
  }

  static async getOrder(id) {
    return await OrdersRepository.getOrder(id);
  }

  static async createOrder(body) {
    return await OrdersRepository.createOrder(body);
  }

  static async updateOrder(id, body) {
    return await OrdersRepository.updateOrder(id, body);
  }

  static async deleteOrder(id) {
    return await OrdersRepository.deleteOrder(id);
  }

  static async getOrder_details() {
    return await OrdersRepository.getOrder_details();
  }

  static async getOrder_detail(id) {
    return await OrdersRepository.getOrder_detail(id);
  }

  static async createOrder_detail(body) {
    return await OrdersRepository.createOrder_detail(body);
  }

  static async updateOrder_detail(id, body) {
    return await OrdersRepository.updateOrder_detail(id, body);
  }

  static async deleteOrder_detail(id) {
    return await OrdersRepository.deleteOrder_detail(id);
  }
}
