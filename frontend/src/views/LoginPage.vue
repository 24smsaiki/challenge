<script setup>
import Login from "../components/LoginPage/Login.vue";
import Header from "../components/Header.vue";
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)" />
  <Login />
</template>
