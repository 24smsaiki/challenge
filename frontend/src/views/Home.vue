<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)" />
  <main>
    <section class="categories">
      <Category product="headphones" />
      <Category product="speakers" />
      <Category product="earphones" />
    </section>
    <AboutSection />
  </main>
</template>

<script>
import Header from "../components/Home/Header.vue";
import Category from "../components/Home/Category.vue";
import AboutSection from "../components/Home/AboutSection.vue";
export default {
  name: "Home",
  components: {
    Header,
    Category,
    AboutSection,
  },
  emits: ["toggle-menu-show"],
};
</script>

<style lang="scss" scoped>
.categories {
  padding: 9.2rem 2.4rem 0 2.4rem;
  @media (min-width: 768px) {
    display: flex;
    justify-content: center;
    padding: 9.6rem 4rem 0 4rem;
  }
  @media (min-width: 1205px) {
    padding: 12rem 16.5rem 0 16.5rem;
  }
}
</style>
