<script setup>
import Header from "../Header.vue";
import SidebarClient from "./client/SidebarClient.vue";
import SidebarSeller from "./seller/SidebarSeller.vue";

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
  <!-- <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header> -->
  <SidebarClient v-if="isClient"></SidebarClient>
  <SidebarSeller v-if="isSeller"></SidebarSeller>
</template>
