import ReturnRepository from "../repositories/ReturnRepository";

export default class ReturnLogic {

    static async getReturns() {
        return await ReturnRepository.getReturns();
    }
    
    static async getReturn(id) {
        return await ReturnRepository.getReturn(id);
    }
    
    static async updateReturn(body) {
        return await ReturnRepository.updateReturn(body);
    }
    
}
