import * as Request from '../services/request';

export default class CarriersRepository {
    static async getCarriers() {
        return await Request.make('get', '/carriers');
    };

    static async getCarrier(id) {
        return await Request.make('get', `/carriers/${id}`);
    };

    static async createCarrier(body) {
        return await Request.make('post', '/carriers', {...body});
    };

    static async updateCarrier(id, body) {
        return await Request.make('put', `/carriers/${id}`, {...body});
    };
}
 