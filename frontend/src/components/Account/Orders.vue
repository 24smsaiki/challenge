<script setup>
import OrdersClient from "./client/OrdersClient.vue";
import OrdersSeller from "./seller/OrdersSeller.vue";

let isSeller = false;
let isClient = true;

const app = JSON.parse(localStorage.getItem("app-user"));

if (app) {
  if (app.roles.indexOf("ROLE_SELLER") !== -1) {
    isSeller = true;
    isClient = false;
  } else if (
    app.roles.indexOf("ROLE_SELLER") === -1 &&
    app.roles.indexOf("ROLE_USER") !== -1
  ) {
    isClient = true;
    isSeller = false;
  }
}
</script>

<template>
  <OrdersClient v-if="isClient"></OrdersClient>
  <OrdersSeller v-if="isSeller"></OrdersSeller>
</template>
