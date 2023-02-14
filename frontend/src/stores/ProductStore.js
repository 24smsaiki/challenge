import ProductsLogic from "../logics/ProductsLogic";
import data from "../data.json";
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
      console.log(state.products);
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
      // try {
      //   const response = await ProductsLogic.getProducts();
      //   this.products = await response.json();
      //   console.log(this.products, "products")
      // } catch (error) {
      //   this.error = error;
      // } finally {
      //   this.loading = false;
      //   console.log(this.products, "products-finally")
      // }
      return await ProductsLogic.getProducts().then((response) => {
        this.products = response.data;
        console.log(this.products, "products");
      }
      ).catch((error) => {
        this.error = error;
      }
      ).finally(() => {
        this.loading = false;
        console.log(this.products, "products-finally");
      }
      );
    },
    async fetchProduct(id) {
      this.loading = true;
      try {
        const response = await ProductsLogic.getProduct(id);
        this.product = await response.json();
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    },
  },
});
