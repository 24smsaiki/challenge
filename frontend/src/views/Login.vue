<script setup>
import Login from "../components/Login/Login.vue";
import Header from "../components/Header.vue";
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <Login />
</template>
