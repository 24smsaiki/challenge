<script setup>
import Header from "../Header.vue";
import SettingsClient from "./client/SettingsClient.vue";
import SettingsSeller from "./seller/SettingsSeller.vue";

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
  <SettingsClient v-if="isClient"></SettingsClient>
  <SettingsSeller v-if="isSeller"></SettingsSeller>
</template>
