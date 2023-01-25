<script setup>
import Header from "../components/Header.vue";
import Register from "../components/RegisterPage/Register.vue";
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)" />
  <Register />
</template>
