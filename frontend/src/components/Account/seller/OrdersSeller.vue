<script setup>
import { createToast } from "mosha-vue-toastify";
import { ref } from "vue";
import OrdersLogic from "../../../logics/Account/seller/OrdersLogic";
import Header from "../../Header.vue";
import Sidebar from "./SidebarSeller.vue";

// Only using to debug and test
const dataUsingToTest = {
  "@context": "/contexts/OrderDetails",
  "@id": "/order_details",
  "@type": "hydra:Collection",
  "hydra:member": [
    {
      "@id": "/order_details/5",
      "@type": "OrderDetails",
      id: 5,
      myOrder: {
        "@id": "/orders/3",
        "@type": "Order",
        reference: "03022023-63dd352630de3",
        createdAt: "2023-02-03T16:24:06+00:00",
        isPaid: true,
        state: 0,
        total: 15.1,
        customer: {
          "@id": "/users/5",
          "@type": "User",
          id: 5,
          email: "user@user.com",
          roles: ["ROLE_USER"],
          Address: ["/addresses/3"],
          orders: ["/orders/3"],
          isPasswordRequest: false,
          isActif: false,
        },
        delivery: "/addresses/2",
        orderDetails: ["/order_details/5"],
        carrier: "/carriers/3",
      },
      item: {
        "@id": "/products/4",
        "@type": "Product",
        id: 4,
        label: "product2Seller2",
        description: "description produit 1",
        price: 12.1,
      },
      quantity: 1,
      totalPrice: 12.1,
    },
    {
      "@id": "/order_details/7",
      "@type": "OrderDetails",
      id: 7,
      myOrder: {
        "@id": "/orders/4",
        "@type": "Order",
        reference: "04022023-63ddb9124bfbd",
        createdAt: "2023-02-04T01:46:58+00:00",
        isPaid: true,
        state: 0,
        total: 27.22,
        customer: {
          "@id": "/users/1",
          "@type": "User",
          id: 1,
          email: "ali.raid@gmail.com",
          roles: ["ROLE_USER"],
          Address: ["/addresses/2"],
          orders: ["/orders/4"],
          firstname: "ali",
          lastname: "raid",
        },
        delivery: "/addresses/2",
        orderDetails: [
          {
            "@id": "/order_details/6",
            "@type": "OrderDetails",
            id: 6,
            myOrder: "/orders/4",
            item: {
              "@id": "/products/1",
              "@type": "Product",
              id: 1,
              label: "productSeller1",
              description: "description produit 1",
              price: 12.12,
            },
            quantity: 1,
            totalPrice: 12.12,
          },
        ],
        carrier: "/carriers/3",
      },
      item: {
        "@id": "/products/3",
        "@type": "Product",
        id: 3,
        label: "product1Seller2",
        description: "description produit 1",
        price: 12.1,
      },
      quantity: 1,
      totalPrice: 12.1,
    },
    {
      "@id": "/order_details/8",
      "@type": "OrderDetails",
      id: 8,
      myOrder: {
        "@id": "/orders/2",
        "@type": "Order",
        reference: "03022023-63dd161ec9484",
        createdAt: "2023-02-03T14:11:42+00:00",
        isPaid: true,
        state: 0,
        total: 27.2,
        customer: {
          "@id": "/users/1",
          "@type": "User",
          id: 1,
          email: "ali.raid@gmail.com",
          roles: ["ROLE_USER"],
          Address: ["/addresses/2"],
          orders: [
            {
              "@id": "/orders/4",
              "@type": "Order",
              reference: "04022023-63ddb9124bfbd",
              createdAt: "2023-02-04T01:46:58+00:00",
              isPaid: true,
              state: 0,
              total: 27.22,
              customer: "/users/1",
              delivery: "/addresses/2",
              orderDetails: [
                {
                  "@id": "/order_details/6",
                  "@type": "OrderDetails",
                  id: 6,
                  myOrder: "/orders/4",
                  item: {
                    "@id": "/products/1",
                    "@type": "Product",
                    id: 1,
                    label: "productSeller1",
                    description: "description produit 1",
                    price: 12.12,
                  },
                  quantity: 1,
                  totalPrice: 12.12,
                },
              ],
              carrier: "/carriers/3",
            },
          ],
          firstname: "ali",
          lastname: "raid",
        },
        delivery: "/addresses/2",
        orderDetails: [
          {
            "@id": "/order_details/3",
            "@type": "OrderDetails",
            id: 3,
            myOrder: "/orders/2",
            item: {
              "@id": "/products/3",
              "@type": "Product",
              id: 3,
              label: "product1Seller2",
              description: "description produit 1",
              price: 12.1,
            },
            quantity: 1,
            totalPrice: 12.1,
          },
        ],
        carrier: "/carriers/3",
      },
      item: {
        "@id": "/products/4",
        "@type": "Product",
        id: 4,
        label: "product2Seller2",
        description: "description produit 1",
        price: 12.1,
      },
      quantity: 1,
      totalPrice: 10,
    },
    {
      "@id": "/order_details/8",
      "@type": "OrderDetails",
      id: 8,
      myOrder: {
        "@id": "/orders/2",
        "@type": "Order",
        reference: "03022023-63dd352630de3",
        createdAt: "2023-02-03T16:24:06+00:00",
        isPaid: true,
        state: 0,
        total: 27.2,
        customer: {
          "@id": "/users/1",
          "@type": "User",
          id: 1,
          email: "ali.raid@gmail.com",
          roles: ["ROLE_USER"],
          Address: ["/addresses/2"],
          orders: [
            {
              "@id": "/orders/4",
              "@type": "Order",
              reference: "04022023-63ddb9124bfbd",
              createdAt: "2023-02-04T01:46:58+00:00",
              isPaid: true,
              state: 0,
              total: 27.22,
              customer: "/users/1",
              delivery: "/addresses/2",
              orderDetails: [
                {
                  "@id": "/order_details/6",
                  "@type": "OrderDetails",
                  id: 6,
                  myOrder: "/orders/4",
                  item: {
                    "@id": "/products/1",
                    "@type": "Product",
                    id: 1,
                    label: "productSeller1",
                    description: "description produit 1",
                    price: 12.12,
                  },
                  quantity: 1,
                  totalPrice: 12.12,
                },
              ],
              carrier: "/carriers/3",
            },
          ],
          firstname: "ali",
          lastname: "raid",
        },
        delivery: "/addresses/2",
        orderDetails: [
          {
            "@id": "/order_details/3",
            "@type": "OrderDetails",
            id: 3,
            myOrder: "/orders/2",
            item: {
              "@id": "/products/3",
              "@type": "Product",
              id: 3,
              label: "product1Seller2",
              description: "description produit 1",
              price: 12.1,
            },
            quantity: 1,
            totalPrice: 12.1,
          },
        ],
        carrier: "/carriers/3",
      },
      item: {
        "@id": "/products/4",
        "@type": "Product",
        id: 4,
        label: "product2Seller2",
        description: "description produit 1",
        price: 12.1,
      },
      quantity: 1,
      totalPrice: 10,
    },
  ],
  "hydra:totalItems": 5,
};

function setToast(message, type) {
  createToast(message, {
    position: "top-right",
    timeout: 5000,
    close: true,
    type: type,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
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
        const response = res.data;
        // const response = dataUsingToTest["hydra:member"];

        orders.value = response.reduce((acc, order) => {
          const reference = order.myOrder.reference;

          order.myOrder["item"] = order.item;
          order.myOrder["quantity"] = order.quantity;
          order.myOrder["totalPrice"] = order.totalPrice;

          if (!acc[reference]) {
            acc[reference] = [];
          }

          acc[reference].push(order.myOrder);

          return acc;
        }, []);
      }
    })
    .catch(() => {
      setToast("Une erreur est survenue lors du chargement", "danger");
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
        <p class="empty">Aucun client n'a passé de commande</p>
        <router-link to="/" class="btn btn-primary"
          >Retour à l'accueil</router-link
        >
      </div>
      <div v-else>
        <div v-for="order in orders" :key="order['@id']" class="mb-6">
          <div class="d-flex justify-content-between mb-2">
            <h1>Référence : {{ order[0].reference }}</h1>
            <p class="text-gray-600">
              Commande passée
              <time
                :datetime="getFormattedDate(order[0].createdAt)"
                class="font-medium text-gray-900"
              >
                {{ getFormattedDate(order[0].createdAt) }}
              </time>
            </p>
          </div>
          <div class="product mb-2">
            <div
              class="d-flex justify-content-between product-detail"
              v-for="orderDetail in order"
              :key="orderDetail.item.id"
            >
              <div class="d-flex flex-column w-100">
                <img
                  src="../../../assets/images/default-product.png"
                  alt="product"
                  class="w-20 h-20 object-cover mb-4"
                />
                <h2 class="text-gray-600 mb-4">
                  <span class="font-bold">Nom : </span>
                  {{ orderDetail.item.label }}
                </h2>
                <h2 class="text-gray-600 mb-4">
                  <span class="font-bold">Acheté par : </span>
                  {{ orderDetail.customer.email }}
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
