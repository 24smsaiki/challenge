<script setup>
import Product from "../components/Category/Product.vue";
import Header from "../components/Header.vue";
import ProductsLogic from "../logics/ProductsLogic";
import { ref } from "vue";
import { createToast } from "mosha-vue-toastify";
import router from "../router/Router";

const products = ref([]);

function setToast(message, type) {
  createToast(message, {
    position: "top-right",
    timeout: 5000,
    close: true,
    type: type,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
  });
}

const redirectToProduct = (product) => router.push(`/product/${product.id}`);

ProductsLogic.getProducts()
  .then((res) => {
    if (res.status === 200) {
      products.value = res.data;
    }
  })
  .catch(() => {
    setToast(
      "Une erreur est survenue lors de la récupération des produits",
      "danger"
    );
  });
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <div class="picks">
    <h2 class="highlight mt-4">Produits</h2>
    <div class="product-cards" v-if="products.length > 0">
      <Product
        v-for="product in products"
        :key="product.id"
        :product="product"
        @click="redirectToProduct(product)"
      />
    </div>
  </div>
</template>

<style scoped>
.product-cards {
  display: flex;
  justify-content: center;
  margin: 50px 0;
  flex-wrap: wrap;
}

.highlight {
  font-size: 30px;
  text-align: center;
}
</style>
