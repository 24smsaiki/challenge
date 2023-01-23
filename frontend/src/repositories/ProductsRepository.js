import * as Request from '../services/request';

export default class ProductsRepository {
    
    static async getProducts() {
        return await Request.make('get', '/api/products');
    };

    static async getProduct(id) {
        return await Request.make('get', `/api/products/${id}`);
    };

    static async createProduct(body) {
        return await Request.make('post', '/api/products', {...body});
    };

    static async updateProduct(id, body) {
        return await Request.make('put', `/api/products/${id}`, {...body});
    };
}