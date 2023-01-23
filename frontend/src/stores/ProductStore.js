import {defineStore } from 'pinia';

export const useProductStore = defineStore({
    id: 'product',
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
        }
    },
    actions: {
        async fetchProducts() {
            this.loading = true;
            try {
                const response = await fetch('http://localhost:3000/products');
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
                const response = await fetch(`http://localhost:3000/products/${id}`);
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
