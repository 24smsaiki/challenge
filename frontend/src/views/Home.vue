<script setup>
import Header from "../components/Home/Header.vue";
import AboutSection from "../components/Home/AboutSection.vue";
defineEmits(["toggle-menu-show"]);
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <main>
    <AboutSection />
  </main>
</template>
