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
        <span class="bold">Description : </span>{{ product.description.slice(0, 30) }}...
      </p>
      <button class="btn btn-primary" @click="addToCart">
       Ajouter au panier
      </button>
    </div>
  </div>
</template>

<script>
import { useCartStore } from "../../stores/CartStore";
import { useProductStore } from "../../stores/ProductStore";
import { createToast } from "mosha-vue-toastify";

export default {
  emits: [["toggle-menu-show", "add-to-cart"]],
  name: "Product",
  props: { product: Object },
  computed: {
    // editSrc() {
    //   return this.product.categoryImage.desktop.slice(2);
    // },
  },
  data() {
    return {
      total: 0,
     
    };
  },
  methods: {
    increaseTotal() {
      this.total++;
    },
    decreaseTotal() {
      if (this.total > 1) {
        this.total--;
      }
    },
    addToCart() {
      const data = {
        productId: this.product.id,
        addedQuantity: this.total,
      };
      useCartStore().addProduct(data);
      // emit the event to the parent component
      this.$emit("add-to-cart", data);

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
    },
    resetTotal () {
      this.total = 1;
    },

  },
};
</script>

<style scoped>

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
  height: 360px;
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
