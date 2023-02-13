<script setup>
import BackOrdersClient from "./client/BackOrdersClient.vue";
import BackOrdersSeller from "./seller/BackOrdersSeller.vue";

let isSeller = false;
let isClient = true;

const app = JSON.parse(localStorage.getItem("app-user"));

if (app) {
  if (app.roles.indexOf("ROLE_SELLER") !== -1) {
    isSeller = true;
    isClient = false;
  } else if (app.roles.indexOf("ROLE_USER") !== -1) {
    isClient = true;
    isSeller = false;
  }
}
</script>

<template>
  <BackOrdersClient v-if="isClient"></BackOrdersClient>
  <BackOrdersSeller v-if="isSeller"></BackOrdersSeller>
</template>
