import ProductsRepository from "../repositories/ProductsRepository";

export default class ProductsLogic {
  static async getProducts() {
    return await ProductsRepository.getProducts();
  }

  static async getProduct(id) {
    return await ProductsRepository.getProduct(id);
  }

  static async createProduct(body) {
    return await ProductsRepository.createProduct(body);
  }

  static async updateProduct(id, body) {
    return await ProductsRepository.updateProduct(id, body);
  }
}
