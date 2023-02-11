<script setup>
import Header from "../../Header.vue";
import Sidebar from "./SidebarClient.vue";
import { ref } from "vue";
import { createToast } from "mosha-vue-toastify";
import OrdersLogic from "../../../logics/OrdersLogic";

// Only using to debug and test
const dataUsingToTest = {
  "@context": "/contexts/Order",
  "@id": "/orders",
  "@type": "hydra:Collection",
  "hydra:member": [
    {
      "@id": "/orders/1",
      "@type": "Order",
      reference: "1",
      createdAt: "2021-07-01T15:00:00+00:00",
      isPaid: true,
      state: 0,
      total: 27.22,
      customer: "/users/1",
      delivery: "/addresses/1",
      user: "/users/1",
      orderDetails: [
        {
          "@id": "/order_details/1",
          "@type": "OrderDetails",
          id: 1,
          myOrder: "/orders/1",
          item: {
            "@id": "/products/1",
            "@type": "Product",
            id: 1,
            label: "productSeller1",
            description: "description produit 1",
            price: 10.5,
          },
          quantity: 1,
          totalPrice: 10.5,
        },
        {
          "@id": "/order_details/2",
          "@type": "OrderDetails",
          id: 2,
          myOrder: "/orders/1",
          item: {
            "@id": "/products/2",
            "@type": "Product",
            id: 2,
            label: "productSeller2",
            description: "description produit 2",
            price: 16.72,
          },
          quantity: 1,
          totalPrice: 16.72,
        },
      ],
      carrier: "/carriers/1",
    },
    {
      "@id": "/orders/2",
      "@type": "Order",
      reference: "2",
      createdAt: "2021-07-01T15:00:00+00:00",
      isPaid: true,
      state: 0,
      total: 27.22,
      customer: "/users/1",
      delivery: "/addresses/1",
      user: "/users/1",
      orderDetails: [
        {
          "@id": "/order_details/3",
          "@type": "OrderDetails",
          id: 3,
          myOrder: "/orders/2",
          item: {
            "@id": "/products/1",
            "@type": "Product",
            id: 1,
            label: "productSeller1",
            description: "description produit 1",
            price: 10.5,
          },
          quantity: 1,
          totalPrice: 10.5,
        },
        {
          "@id": "/order_details/4",
          "@type": "OrderDetails",
          id: 4,
          myOrder: "/orders/2",
          item: {
            "@id": "/products/2",
            "@type": "Product",
            id: 2,
            label: "productSeller2",
            description: "description produit 2",
            price: 16.72,
          },
          quantity: 1,
          totalPrice: 16.72,
        },
      ],
      carrier: "/carriers/1",
    },
  ],
  "hydra:totalItems": 2,
};

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
const getOrders = () => {
  OrdersLogic.getOrders(orders)
    .then((res) => {
      if (res.status === 200) {
        orders.value = res.data;
        // orders.value = dataUsingToTest["hydra:member"];
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
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <section id="orders">
    <Sidebar />
    <div class="content">
      <div v-if="orders.length === 0" class="empty-card">
        <p class="empty">Vous n'avez pas encore passé de commande</p>
        <div>
          Achetez des produits sur notre
          <router-link to="/products" class="text-blue-500"
            >boutique</router-link
          >
        </div>
        <router-link to="/" class="btn btn-primary"
          >Retour à l'accueil</router-link
        >
      </div>
      <div v-else>
        <div v-for="order in orders" :key="order['@id']" class="mb-6">
          <div class="d-flex justify-content-between mb-2">
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
          <div class="product mb-2">
            <div
              class="d-flex justify-content-between product-detail"
              v-for="orderDetail in order.orderDetails"
              :key="orderDetail.id"
            >
              <div class="d-flex flex-column w-100">
                <img
                  src="../../assets/images/default-product.png"
                  alt="product"
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
                  {{ orderDetail.totalPrice }} €
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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

  .text-gray-600 {
    font-size: 18px;
  }
}
</style>
