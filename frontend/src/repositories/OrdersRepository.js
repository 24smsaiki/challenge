import * as Request from '../services/request';

export default class OrdersRepository {

    static async pass_order(body){
        return await Request.make('post', '/order/pass', {...body});
    }

    static async confirmOrder(id) {
        return await Request.make('get', `/order/payment/success/${id}`);
    }

    static async getOrders() {
        return await Request.make('get', '/orders');
    };

    static async getOrder(id) {
        return await Request.make('get', `/orders/${id}`);
    };

    static async createOrder(body) {
        return await Request.make('post', '/orders', {...body});
    };

    static async updateOrder(id, body) {
        return await Request.make('put', `/orders/${id}`, {...body});
    };

    static async deleteOrder(id) {
        return await Request.make('delete', `/orders/${id}`);
    }

    static async getOrder_details() {
        return await Request.make('get', '/order_details');
    }

    static async getOrder_detail(id) {
        return await Request.make('get', `/order_details/${id}`);
    }

    static async createOrder_detail(body) {
        return await Request.make('post', '/order_details', {...body});
    }

    static async updateOrder_detail(id, body) {
        return await Request.make('put', `/order_details/${id}`, {...body});
    }

    static async deleteOrder_detail(id) {
        return await Request.make('delete', `/order_details/${id}`);
    }

}