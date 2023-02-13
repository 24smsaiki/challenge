<script setup>
import { createToast } from "mosha-vue-toastify";
import { ref } from "vue";
import OrdersLogic from "../../../logics/OrdersLogic";
import Header from "../../Header.vue";
import Sidebar from "../Sidebar.vue";

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

function getFormattedDate(dateTime) {
  const date = new Date(dateTime);
  const day = date.getDate().toString().padStart(2, "0");
  const month = (date.getMonth() + 1).toString().padStart(2, "0");
  const year = date.getFullYear();
  const hours = date.getHours().toString().padStart(2, "0");
  const minutes = date.getMinutes().toString().padStart(2, "0");
  const seconds = date.getSeconds().toString().padStart(2, "0");
  return `${day}/${month}/${year} à ${hours}:${minutes}:${seconds}`;
}

const ordersBack = ref([]);

const getBackClientOrders = () => {
  OrdersLogic.getBackClientOrders(ordersBack)
    .then((res) => {
      if (res.status === 200) {
        ordersBack.value = res.data;
      }
    })
    .catch(() => {
      setToast(
        "Une erreur est survenue lors du chargement des commandes de retour",
        "danger"
      );
    });
};

getBackClientOrders();
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <section id="ordersBack">
    <Sidebar />
    <div class="content">
      <div v-if="ordersBack.length === 0" class="empty-card">
        <p class="empty">Vous n'avez pas encore de commandes de retour</p>
        <div>
          Retourner vos produits via l'espace mes
          <router-link to="/account/orders">commandes</router-link>
        </div>
        <router-link to="/" class="btn">Retour à l'accueil</router-link>
      </div>
      <div v-else>
        <div v-for="order in ordersBack" :key="order.id" class="order">
          <div class="d-flex justify-content-between mb-4">
            <h1>Référence : {{ order.reference }}</h1>
            <p class="text-gray-600">
              Commande passée
              <time
                :datetime="getFormattedDate(order.createdAt)"
                class="font-medium text-gray-900"
              >
                {{ getFormattedDate(order.createdAt) }}
              </time>
            </p>
          </div>
          <div class="product mb-4">
            <div
              class="d-flex justify-content-between product-detail"
              v-for="orderDetail in order.orderDetailsReturns"
              :key="orderDetail.id"
            >
              <div class="d-flex flex-column w-100">
                <img
                  src="../../../assets/images/default-product.png"
                  alt="Default product"
                  class="w-20 h-20 object-cover mb-4"
                />
                <h2 class="text-gray-600 mb-4">
                  <span class="font-bold">Nom: </span>
                  {{ orderDetail.item.label }}
                </h2>
                <p class="text-gray-600 mb-4 d-flex flex-column">
                  <span class="font-bold">Description : </span>
                  <textarea
                    class="pl-2 pr-2"
                    disabled
                    v-model="orderDetail.item.description"
                  ></textarea>
                </p>
                <p class="text-gray-600 mb-4">
                  <span class="font-bold">Prix :</span>
                  {{ orderDetail.item.price }} €
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style lang="scss">
#ordersBack .content {
  overflow: auto;

  .empty-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    font-size: 18px;
    font-style: italic;

    a {
      text-decoration: underline;
    }
  }

  h1 {
    font-size: 20px;
  }

  .d-flex {
    display: flex;
  }

  textarea {
    resize: none;
    border: 1px solid black;
    background-color: white;
  }

  .justify-content-between {
    justify-content: space-between;
  }

  .flex-column {
    flex-direction: column;
  }

  .product-detail {
    border-radius: 0.5rem;
    padding: 1rem;
  }

  .w-100 {
    width: 100%;
  }

  .order {
    border: 1px solid black;
    border-radius: 0.5rem;
    padding: 1rem;
  }

  .text-gray-600 {
    font-size: 18px;
  }
}
</style>
