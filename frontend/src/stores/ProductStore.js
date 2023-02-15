import ProductsLogic from "../logics/ProductsLogic";
import { defineStore } from "pinia";

export const useProductStore = defineStore({
  id: "product",
  state: () => ({
    products: [],
    currentProduct: {},
    loading: false,
    error: null,
  }),
  getters: {
    getProductById: (state) => (id) => {
      return state.products.find((product) => product.id === id);
    },
    getProductsByCategory: (state) => (category) => {
      return state.products.filter((product) => product.category === category);
    },
    getProducts: (state) => {
      return state.products;
    },
    getProduct: (state) => {
      return state.currentProduct;
    },
  },
  actions: {
    async fetchProducts() {
      this.loading = true;
      return await ProductsLogic.getProducts()
        .then((response) => {
          this.products = response.data;
        })
        .catch((error) => {
          this.error = error;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    async fetchProduct(id) {
      this.loading = true;
      return await ProductsLogic.getProduct(id)
        .then((response) => {
          this.product = response.data;
        })
        .catch((error) => {
          this.error = error;
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
});
