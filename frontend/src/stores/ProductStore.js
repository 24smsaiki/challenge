import {defineStore } from 'pinia';
import ProductsLogic from '../logics/ProductsLogic';
import data from '../data.json';

export const useProductStore = defineStore({
    id: 'product',
    state: () => ({
        products: data,
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
        }
    },
    actions: {
        async fetchProducts() {
            this.loading = true;
            try {
                const response = await ProductsLogic.getProducts();
                console.log(response)
                this.products = await response.json();
            }
            catch (error) {
                this.error = error;
            }
            finally {
                this.loading = false;
            }
        },
        async fetchProduct(id) {
            this.loading = true;
            try {
                const response = await ProductsLogic.getProduct(id);
                this.product = await response.json();
            }
            catch (error) {
                this.error = error;
            }
            finally {
                this.loading = false;
            }
        },
    },
});
