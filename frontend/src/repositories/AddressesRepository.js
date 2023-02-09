import * as Request from '../services/request';

export default class AddressesRepository {
    static async getAddresses() {
        return await Request.make('get', '/addresses');
    };

    static async getAddress(id) {
        return await Request.make('get', `/addresses/${id}`);
    };

    static async createAddress(body) {
        return await Request.make('post', '/addresses', {...body});
    };

    static async updateAddress(id, body) {
        return await Request.make('put', `/addresses/${id}`, {...body});
    };
}

