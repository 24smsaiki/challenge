<script setup>
import Sidebar from "./SidebarClient.vue";
import { ref } from "vue";
import { createToast } from "mosha-vue-toastify";
import OrdersLogic from "../../../logics/OrdersLogic";
import ModalComponent from "../ModalComponent.vue";
import router from "../../../router/Router";

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

const orders = ref([]);
const isBackOrder = ref(false);
const modalIsOpen = ref(false);
const modalTitle = ref("");
const modalContent = ref("");
const currentBackOrder = ref({});
const modalOrder = ref({});
const returnItems = ref({
  itemsToReturn: [],
  orderReference: "",
});

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

const makeBackOrder = (order) => {
  if (!checkIfAllOrderDetailsAreDisabled(order)) {
    isBackOrder.value = true;
    currentBackOrder.value = order;
  }
};

const cancelBackOrder = () => {
  isBackOrder.value = false;
  currentBackOrder.value = {};
};

const confirmBackOrder = (reference, order, id) => {
  if (order.state === 0) {
    modalTitle.value = "Confirmation de retour";
    modalContent.value = "Quel est le motif de votre retour ?";
    modalIsOpen.value = true;
    modalOrder.value = {
      reference: reference,
      id: id,
      order: order,
    };
  }
};

const openModalStateChange = () => (modalIsOpen.value = false);
const cancelModalStateChange = () => {
  modalIsOpen.value = false;
};

const validateBackOrders = () => {
  OrdersLogic.createOrdersReturn(returnItems.value)
    .then((res) => {
      if (res.status === 201) {
        setToast("Le retour a bien été pris en compte", "success");
        isBackOrder.value = false;
        currentBackOrder.value = {};
        returnItems.value = {
          itemsToReturn: [],
          orderReference: "",
        };
        router.push({ name: "Orders" });
        getOrders();
      }
    })
    .catch(() => {
      setToast(
        "Une erreur est survenue lors de la création du retour",
        "danger"
      );
    });
};

const gestStyleToReturnOrderDetail = (state) => {
  if (state !== 0) {
    return {
      cursor: "not-allowed",
      backgroundColor: "#e0e0e0",
    };
  } else {
    return {};
  }
};

const checkIfAllOrderDetailsAreDisabled = (order) => {
  let count = 0;

  order.orderDetails.forEach((orderDetail) => {
    if (orderDetail.state === 1) {
      count += 1;
    }
  });

  return count === order.orderDetails.length || order.state !== 5;
};

const checkIfAllOrderDetailsAreDisabledStyle = (order) => {
  if (checkIfAllOrderDetailsAreDisabled(order)) {
    return {
      cursor: "not-allowed",
      backgroundColor: "#e0e0e0",
    };
  } else {
    return {};
  }
};

const acceptModalStateChange = (order, reason) => {
  if (reason !== "" && reason.length > 10) {
    returnItems.value.itemsToReturn.push({
      itemId: order.order.item.id,
      reason: reason,
      totalPrice: order.order.totalPrice,
      idOrderDetailsConcerned: order.order.id,
    });
    returnItems.value.orderReference = order.reference;
    modalIsOpen.value = false;
    validateBackOrders();
  }
};

const getOrders = () => {
  OrdersLogic.getOrders(orders)
    .then((res) => {
      if (res.status === 200) {
        orders.value = res.data;
      }
    })
    .catch(() => {
      setToast(
        "Une erreur est survenue lors du chargement des commandes",
        "danger"
      );
    });
};

getOrders();
</script>

<template>
  <section id="orders">
    <Sidebar />
    <div class="content">
      <div v-if="orders.length === 0" class="empty-card">
        <p class="empty">Vous n'avez pas encore passé de commande</p>
        <div>
          Achetez des produits sur notre
          <router-link to="/products" class="boutiqueName"
            >boutique</router-link
          >
        </div>
        <router-link to="/" class="btn home-page"
          >Retour à l'accueil</router-link
        >
      </div>
      <div v-else>
        <div v-if="!isBackOrder">
          <div v-for="order in orders" :key="order['@id']" class="mb-6">
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
                v-for="orderDetail in order.orderDetails"
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
                  <p class="text-gray-600 mb-4">
                    <span class="font-bold">Quantité :</span>
                    {{ orderDetail.quantity }}
                  </p>
                  <p class="text-gray-600">
                    <span class="font-bold">Total : </span>
                    {{ orderDetail.totalPrice * orderDetail.quantity }} €
                  </p>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <button
                class="btn"
                @click="makeBackOrder(order)"
                :disabled="checkIfAllOrderDetailsAreDisabled(order)"
                :style="checkIfAllOrderDetailsAreDisabledStyle(order)"
              >
                Demander un retour
              </button>
              <p class="text-gray-600">
                <span class="font-bold text-green-900">Total : </span>
                <span class="font-bold text-green-900"
                  >{{ order.total }} €</span
                >
              </p>
            </div>
          </div>
        </div>
        <div v-if="isBackOrder">
          <button class="btn mb-4" @click="cancelBackOrder(order)">
            Annuler le retour
          </button>
          <div class="product-back">
            <h1 class="mb-4">Référence : {{ currentBackOrder.reference }}</h1>
            <div
              class="d-flex justify-content-between product-detail mb-4"
              v-for="orderToBack in currentBackOrder.orderDetails"
              :key="orderToBack.id"
            >
              <div class="d-flex flex-column w-100">
                <img
                  src="../../../assets/images/default-product.png"
                  alt="Default product"
                  class="w-20 h-20 object-cover mb-4"
                />
                <h2 class="text-gray-600 mb-4">
                  <span class="font-bold">Nom: </span>
                  {{ orderToBack.item.label }}
                </h2>
                <p class="text-gray-600 mb-4 d-flex flex-column">
                  <span class="font-bold">Description : </span>
                  <textarea
                    class="pl-2 pr-2"
                    disabled
                    v-model="orderToBack.item.description"
                  ></textarea>
                </p>
                <p class="text-gray-600 mb-4">
                  <span class="font-bold">Prix :</span>
                  {{ orderToBack.item.price }} €
                </p>
                <p class="text-gray-600 mb-4">
                  <span class="font-bold">Quantité :</span>
                  {{ orderToBack.quantity }}
                </p>
                <p class="text-gray-600">
                  <span class="font-bold">Total : </span>
                  {{ orderToBack.totalPrice }} €
                </p>
                <button
                  class="btn confirmBack mt-4"
                  :disabled="orderToBack.state !== 0"
                  :style="gestStyleToReturnOrderDetail(orderToBack.state)"
                  @click="
                    confirmBackOrder(
                      currentBackOrder.reference,
                      orderToBack,
                      currentBackOrder.id
                    )
                  "
                >
                  Retourner le produit
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div v-if="modalIsOpen && modalContent && modalTitle && modalOrder">
    <ModalComponent
      :modalIsOpen="modalIsOpen"
      :modalContent="modalContent"
      :modalOrder="modalOrder"
      :modalTitle="modalTitle"
      @openModalStateChange="openModalStateChange"
      @cancelModalStateChange="cancelModalStateChange"
      @acceptModalStateChange="acceptModalStateChange"
    ></ModalComponent>
  </div>
</template>

<style scoped lang="scss">
#orders .content {
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

  .boutiqueName {
    color: #d87d4a;
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

  .product {
    border: 1px solid black;
    border-radius: 0.5rem;
    padding: 1rem;
  }

  .product-back .product-detail {
    border: 1px solid black;
    border-radius: 0.5rem;
    padding: 1rem;
  }

  .text-gray-600 {
    font-size: 18px;
  }

  .btn:not(.home-page) {
    padding: 10px 20px;
    background-color: #808080;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;

    &.confirmBack {
      width: fit-content;
    }

    &:hover {
      background-color: #666666;
    }
  }
}
</style>
