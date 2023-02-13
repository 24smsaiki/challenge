<script setup>
import Header from "../components/Header.vue";
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <h1>Products</h1>
</template>