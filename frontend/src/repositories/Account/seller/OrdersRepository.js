import * as Request from "../../../services/request";

export default class OrdersRepository {
  static async getOrders() {
    return await Request.make("get", "/order_details");
  }
}