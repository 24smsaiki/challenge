<script setup>
import AccountClient from "./client/AccountClient.vue";
import AccountSeller from "./seller/AccountSeller.vue";

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
  <AccountClient v-if="isClient"></AccountClient>
  <AccountSeller v-if="isSeller"></AccountSeller>
</template>
