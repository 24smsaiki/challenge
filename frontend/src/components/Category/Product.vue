<script setup>
import { useCartStore } from "../../stores/CartStore";
import { createToast } from "mosha-vue-toastify";
import { ref, defineEmits, defineProps, inject } from "vue";

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
});

const total = ref(0);
const cartStore = useCartStore();
const ProvideRefreshCart = inject("ProvideRefreshCart");

defineEmits(["toggle-menu-show", "add-to-cart", "refresh-cart"]);

const increaseTotal = () => {
  total.value++;
};

const decreaseTotal = () => {
  if (total.value > 1) {
    total.value--;
  }
};

const addToCart = () => {
  if (total.value > 0) {
    const data = {
      productId: props.product.id,
      addedQuantity: total.value,
    };
    cartStore.addProduct(data);
    ProvideRefreshCart();
    total.value = 0;

    createToast("Produit ajouté au panier", {
      position: "top-right",
      timeout: 5000,
      close: true,
      type: "success",
      showCloseButtonOnHover: false,
      hideProgressBar: false,
      closeButton: "button",
      icon: true,
      rtl: false,
    });
  }
};
</script>

<template>
  <div class="card">
    <div class="card-img">
      <img
        src="../../assets/images/default-product.png"
        class="img-fluid"
        alt="Default image"
      />
    </div>
    <div class="product-info">
      <h4 class="product-name">
        <span class="bold">Nom : </span>{{ product.label }}
      </h4>
      <p class="price">
        <span class="bold">Prix : </span>{{ product.price }} €
      </p>
      <p class="description">
        <span class="bold">Description : </span
        >{{ product.description.slice(0, 30) }}...
      </p>
      <div
        v-if="!product.stockQuantity <= 0"
        class="overview__text__btn-section"
      >
        <div class="overview__text__btn-section__number">
          <button
            class="overview__text__btn-section__number__less"
            @click="decreaseTotal"
          >
            -
          </button>
          <p class="overview__text__btn-section__number__value">
            {{ total }}
          </p>
          <button
            class="overview__text__btn-section__number__more"
            @click="increaseTotal"
          >
            +
          </button>
        </div>
        <button
          :class="[
            'overview__text__btn-section__btn',
            'default-btn',
            justAdded ? 'just-added' : '',
            total === 0 ? 'cursor-disabled' : '',
          ]"
          :disabled="total === 0"
          @click="addToCart"
        >
          Ajouter au panier
        </button>
      </div>
      <div class="mt-2" v-else>
        <p class="bold text-danger">Produit en rupture de stock</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.cursor-disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

.text-danger {
  color: red;
}

.overview__text__btn-section {
  display: flex;
  justify-content: space-between;
  margin-top: 1rem;
}

.disabled-btn {
  opacity: 0.5;
  cursor: not-allowed;
}

.overview__text__btn-section__number__less {
  padding: 5px;
}

.default-btn {
  font-size: 1.3rem !important;
  padding: 0 !important;
}

.overview__text__btn-section__number {
  width: 35%;
  display: flex;
  align-items: center;
}
.overview__text__btn-section__number__more {
  padding: 5px;
}

.overview__text__btn-section__btn {
  height: 40px;
  width: 65%;
}

.overview__text__btn-section__number__value {
  padding: 5px;
}
.btn {
  background-color: blue;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  transition: 0.4s;
  border-radius: 5px;
}

.btn-primary {
  background-color: blue;
  color: white;
}

.card {
  box-shadow: 0 0 5px #00000040;
  transition: 0.4s;
  cursor: pointer;
  display: flex;
  flex-wrap: wrap;
  flex-direction: row;
  width: 20%;
  margin: 15px 20px;
  height: 400px;
}

.card:hover {
  box-shadow: 0 0 10px #00000040;
  transform: scale(1.02);
}

.bold {
  font-weight: bold;
}

.card-img {
  width: 200px;
  padding: 1.2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 60%;
}

.card-img img {
  width: 70%;
}

.product-info {
  display: flex;
  flex-direction: column;
  padding: 1rem;
  justify-content: center;
  align-items: flex-start;
  height: 40%;
  width: 100%;
  font-size: 14px;
}

.product-name {
  padding: 0;
  margin: 0;
}

.price {
  margin: 0;
}

.price span {
  color: var(--green);
}

.stars {
  list-style: none;
  display: flex;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
  justify-content: center;
  align-items: center;
}

.star {
  color: var(--yellow);
}

.count {
  color: var(--blue);
  padding-left: 5px;
}

@media screen and (max-width: 750px) {
  .card-img {
    height: 40%;
  }

  .product-info {
    height: 60%;
    width: 100%;
  }
}

@media screen and (max-width: 500px) {
  .card {
    width: 80%;
    justify-content: center;
    height: 165px;
  }

  .card-img {
    width: 40%;
    height: auto;
    padding: 0;
  }

  .product-info {
    width: 60%;
    padding-right: 0.5rem;
    height: auto;
  }
}
</style>
