import * as Request from '../services/request';

export default class AuthRepository {
    static async login({email, password}) {
        return await Request.make('post', '/auth', { email, password })
    }

    static async register(body) {
        return await Request.make('post', '/register', {...body});
    }

    static async logout() {
        return await Request.make('post', '/logout');
    }

    static async refresh() {
        return await Request.make('post', '/refresh');
    }

    static async me() {
        return await Request.make('get', '/me', { params: { include: 'roles' } });
    }
    static refreshToken(refreshToken) {
        return Request.make('post', '/oauth/token', { refresh_token: refreshToken });
    }

}
