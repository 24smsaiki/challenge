import * as Request from '../services/request';

export default class ReturnRepository {
    
        static async getReturns() {
            return await Request.make('get', '/order_returns');
        }
        
        static async getReturn(id) {
            return await Request.make('get', `/returns/${id}`);
        }
        
        static async updateReturn(id, body) {
            return await Request.make('put', `/returns/${id}`, { ...body });
        }

        
    }