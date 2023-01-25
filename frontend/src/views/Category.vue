<template>
  <Header
    :category="category"
    @toggle-menu-show="$emit('toggle-menu-show', $event)"
  />

  <div class="picks">
    <h2 class="highlight">Produits</h2>
    <div class="product-cards">
      <Product
        v-for="product in sortedProducts"
        :key="product.id"
        :product="product"
      />
    </div>
  </div>
  <ProductNavigation />
</template>

<script>
import ProductNavigation from "../components/ProductNavigation.vue";
import Header from "../components/Category/Header.vue";
import Product from "../components/Category/Product.vue";
import jsonData from "../data.json";
export default {
  name: "Category",
  components: { ProductNavigation, Header, Product },
  emits: ["toggle-menu-show"],
  data() {
    return {
      productInfo: jsonData,
    };
  },
  computed: {
    category() {
      return this.$route.params.category;
    },
    headphones() {
      return this.productInfo.filter(
        (product) => product.category === "headphones"
      );
    },
    earphones() {
      return this.productInfo.filter(
        (product) => product.category === "earphones"
      );
    },
    speakers() {
      return this.productInfo.filter(
        (product) => product.category === "speakers"
      );
    },
    currentProducts() {
      return this.category === "headphones"
        ? this.headphones
        : this.category === "earphones"
        ? this.earphones
        : this.speakers;
    },
    sortedProducts() {
      return this.currentProducts.slice().sort((a, b) => b.new - a.new);
    },
  },
};
</script>

<style scoped>
h2 {
  color: #000;
  font-size: 1.5rem;
  font-weight: 300;
  text-align: center;
  text-transform: uppercase;
  position: relative;
  margin: 1rem;
}

h2::after {
  content: "";
  width: 100px;
  position: absolute;
  margin: 0 auto;
  height: 4px;
  background: rgba(0, 0, 0, 0.2);
  left: 0;
  right: 0;
  bottom: -20px;
}

.picks {
  background-color: white;
  padding: 1rem;
  margin: 1rem 0;
}

.picks .highlight {
  color: var(--green);
}

.product-cards {
  display: flex;
  padding: 2rem 0;
  gap: 1rem;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
}

@media screen and (max-width: 500px) {
  .picks {
    margin: 0;
    padding: 0;
  }
  .product-cards {
    flex-direction: column;
  }
}
</style>
