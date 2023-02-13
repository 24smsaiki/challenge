import UsersRepository from "../repositories/UsersRepository";

export default class UsersLogic {
    static async getUsers() {
        return await UsersRepository.getUsers();
    }
    
    static async getUser(id) {
        return await UsersRepository.getUser(id);
    }
    
    static async createUser(body) {
        return await UsersRepository.createUser(body);
    }
    
    static async updateUser(id, body) {
        return await UsersRepository.updateUser(id, body);
    }
    
    static async deleteUser(id) {
        return await UsersRepository.deleteUser(id);
    }
    
    static async getSellers() {
        return await UsersRepository.getSellers().then((result) => {
        return result.data.filter(seller => seller.isActif === true);
        });
    }

    static async getRequestSellers() {
        return await UsersRepository.getSellers().then((result) => {
        return result.data.filter(seller => seller.is_pending === true);
        });
    }

    static async declineRequestSellers(idSeller) {
        return await UsersRepository.declineRequestSellers(idSeller);
    }

    static async acceptRequestSellers(idSeller) {
        return await UsersRepository.acceptRequestSellers(idSeller);
    }
        
    
    }
