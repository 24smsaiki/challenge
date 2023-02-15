<script setup>
import Header from "../Header.vue";
import ProfileClient from "./client/ProfileClient.vue";
import ProfileSeller from "./seller/ProfileSeller.vue";

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
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <ProfileClient v-if="isClient"></ProfileClient>
  <ProfileSeller v-if="isSeller"></ProfileSeller>
</template>
