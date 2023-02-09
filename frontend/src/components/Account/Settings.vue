<script setup>
import Header from "../Header.vue";
import Sidebar from "./Sidebar.vue";
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <section id="settings">
    <Sidebar />
    <div class="content">
      <h1>Settings</h1>
      <p>
        Lorem ipsum dolor sit amet consectetur adipi sicing elit. Quisquam,
        quod. Quisquam, quod. Quisquam, quod. Quisquam, quod.
      </p>
    </div>
  </section>
</template>
