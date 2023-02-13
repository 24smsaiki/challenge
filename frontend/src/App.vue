<script setup>
import Footer from "./components/Footer.vue";
import Cart from "./components/Cart.vue";
import data from "./data.json";
import UserProvider from "./components/Providers/UserProvider.vue";
import { ref, onMounted } from "vue";
import Menu from "./components/Menu.vue";

const showMenu = ref(false);
const showCart = ref(false);
const showConfirmation = ref(false);
const scrollTop = ref(false);
const cart = ref([]);
const products = ref(data); // TODO make this API

const toggleMenu = (myVar) => {
  if (myVar === "logo") {
    showMenu.value = false;
    showCart.value = false;
  } else if (myVar === "menu") {
    showMenu.value = !showMenu.value;
  } else if (myVar === "cart") {
    showCart.value = !showCart.value;
  } else if (myVar === "confirmation") {
    showConfirmation.value = !showConfirmation.value;
  }

  scrollTop.value = !scrollTop.value;
};

const storeCart = () => {
  localStorage.setItem("cart", JSON.stringify(cart.value));
};

const addToCart = (data) => {
  let product = products.value.find((product) => product.id === data.productId);
  if (cart.value.find((prod) => prod.id === product.id)) {
    const index = cart.value.findIndex((prod) => prod.id === product.id);
    cart.value[index] = {
      ...cart.value[index],
      addedQuantity: cart.value[index].addedQuantity + data.addedQuantity,
    };
  } else {
    product = { ...product, addedQuantity: data.addedQuantity };
    cart.value.push(product);
  }
  storeCart();
};

const changeQuantity = (data) => {
  const index = cart.value.findIndex((prod) => prod.id === data.productId);

  if (data.operation === "subtract") {
    if (cart.value[index].addedQuantity === 1) {
      cart.value = cart.value
        .slice()
        .filter((prod) => prod.id !== data.productId);
    } else {
      cart.value[index] = {
        ...cart.value[index],
        addedQuantity: cart.value[index].addedQuantity - 1,
      };
    }
  } else if (data.operation === "add") {
    cart.value[index] = {
      ...cart.value[index],
      addedQuantity: cart.value[index].addedQuantity + 1,
    };
  }

  storeCart();
};

const emptyCart = () => {
  cart.value = [];
  storeCart();
};

onMounted(() => {
  console.log(localStorage);
  cart.value = JSON.parse(localStorage.getItem("cart")) ? JSON.parse(localStorage.getItem("cart")) : [];
});
</script>

<template>
  <UserProvider>
    <Menu :show="showMenu" :scrollTop="scrollTop" ref="mobileMenu" />
    <Cart
      :show="showCart"
      :cart="cart"
      @change-quantity="changeQuantity"
      @empty-cart="emptyCart"
      @toggle-menu-show="toggleMenu"
    />
    <router-view
      @toggle-menu-show="toggleMenu"
      @add-to-cart="addToCart"
      @empty-cart="emptyCart"
      :cart="cart"
      :showConfirmation="showConfirmation"
    />

      <Footer v-if="!$route.path.startsWith('/admin')" />
  </UserProvider>
</template>

<script>
import Footer from "./components/Footer.vue";
import Menu from "./components/Menu.vue";
import Cart from "./components/Cart.vue";
import data from "./data.json";
import UserProvider from "./components/Providers/UserProvider.vue";

export default {
  name: "App",
  components: { Footer, Menu, Cart, UserProvider },
  data() {
    return {
      showMenu: false,
      showCart: false,
      showConfirmation: false,
      scrollTop: false,
      cart: [],
      products: data,
    };
  },
  methods: {
    toggleMenu(myVar) {
      if (myVar === "logo") {
        this.showMenu = false;
        this.showCart = false;
      } else if (myVar === "menu") {
        this.showMenu = !this.showMenu;
      } else if (myVar === "cart") {
        this.showCart = !this.showCart;
      } else if (myVar === "confirmation") {
        this.showConfirmation = !this.showConfirmation;
      }
      this.scrollTop = !this.scrollTop;
    },
    storeCart() {
      localStorage.setItem("cart", JSON.stringify(this.cart));
    },
    addToCart(data) {
      let product = this.products.find(
        (product) => product.id === data.productId
      );
      if (this.cart.find((prod) => prod.id === product.id)) {
        const index = this.cart.findIndex((prod) => prod.id === product.id);
        this.cart[index] = {
          ...this.cart[index],
          addedQuantity: this.cart[index].addedQuantity + data.addedQuantity,
        };
      } else {
        product = { ...product, addedQuantity: data.addedQuantity };
        this.cart.push(product);
      }
      this.storeCart();
    },
    changeQuantity(data) {
      const index = this.cart.findIndex((prod) => prod.id === data.productId);
      if (data.operation === "subtract") {
        if (this.cart[index].addedQuantity === 1) {
          this.cart = this.cart
            .slice()
            .filter((prod) => prod.id !== data.productId);
        } else {
          this.cart[index] = {
            ...this.cart[index],
            addedQuantity: this.cart[index].addedQuantity - 1,
          };
        }
      } else if (data.operation === "add") {
        this.cart[index] = {
          ...this.cart[index],
          addedQuantity: this.cart[index].addedQuantity + 1,
        };
      }
      this.storeCart();
    },
    emptyCart() {
      this.cart = [];
      this.storeCart();
    },
  },
  created() {
    if (localStorage.getItem("cart") === null) {
      localStorage.setItem("cart", JSON.stringify(this.cart));
    }
  },
  mounted() {
    this.cart = JSON.parse(localStorage.getItem("cart"));
  },
};
</script>

<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;500;600;700;800&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Manrope", sans-serif;
}

html {
  font-size: 62.5%;
}

body {
  &::-webkit-scrollbar {
    width: 0.7rem;
  }

  &::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey;
    border-radius: 1rem;
  }

  &::-webkit-scrollbar-thumb {
    background: #d87d4a;
    border-radius: 1rem;
  }

  &::-webkit-scrollbar-thumb:hover {
    background: #f6af85;
  }
}

a {
  text-decoration: none;
}

ul {
  list-style: none;
}

button {
  cursor: pointer;
}

.default-btn {
  background: #d87d4a;
  color: white;
  text-transform: uppercase;
  font-weight: 700;
  font-size: 1.3rem;
  line-height: 1.776rem;
  letter-spacing: 0.1rem;
  border: none;
  padding: 1.5rem 3rem;
  transition: all 0.3s ease;

  &:hover {
    background: #f6af85;
  }
}

.wrapper {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 100vh;
}

.stop-scroll {
  max-height: calc(100vh - 9.9rem);
  overflow: hidden;
}
</style>
