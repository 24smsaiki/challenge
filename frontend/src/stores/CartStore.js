import { defineStore } from 'pinia';
import { useProductStore } from './ProductStore';


export const useCartStore = defineStore({
    id: 'cart',
    state: () => ({
        cart: [],
    }),
    getters: {
        total() {
            return this.cart.reduce((total, item) => total + item.price, 0);
        },
        cartEmpty() {
            return this.cart.length === 0;
        }
    },
    actions: {
        addProduct({productId, addedQuantity}) {
            const productStore = useProductStore();
            const product = productStore.getProductById(productId);
            const productFromCart = this.cart.find((item) => item.product.id === productId);

            if(productFromCart) {
                productFromCart.addedQuantity += addedQuantity;
                return;
            } else {
                this.cart.push({
                    product,
                    addedQuantity,
                });
            };
        this.storeCart();
        },
        removeProduct(productId) {
           const productFromCartIndex = this.cart.findIndex((item) => item.id === productId);

              if(productFromCartIndex !== -1) {
                    if(this.cart[productFromCartIndex].addedQuantity > 1) {
                        this.cart[productFromCartIndex].addedQuantity--;
                    } else {
                        this.cart.splice(productFromCartIndex, 1);
                    }
                }
            this.storeCart();
        },
        clearCart() {
            this.cart = [];
        },
        changeQuantity(data) {
            if(data.operation === 'substract') {
                this.removeProduct(data.productId);
            } else if(data.operation === 'add') {
                this.addProduct(data);
            }
            this.storeCart();
        },
        storeCart() {
            localStorage.setItem('cart', JSON.stringify(this.cart));
        }
    },
    
});

