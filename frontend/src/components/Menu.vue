<script setup>
import { inject } from "vue";
const isAuth = inject("ProviderIsAuth");
defineProps(["show"]);
defineEmits(["toggle-menu-show"]);
</script>

<template>
  <div :class="['overlay', show ? 'showElement' : 'hideElement']"></div>
  <div :class="['menu', show ? 'showElement' : 'hideElement']" ref="mobileMenu">
    <section class="links">
      <ul class="navbar__desktop-menu ml-30">
        <li class="navbar__desktop-menu__link">
          <router-link active-class="active" to="/">Accueil</router-link>
          <router-link active-class="active" to="/products" v-if="isAuth"
            >Produits</router-link
          >
          <router-link active-class="active" v-if="isAuth" to="/account"
            >Compte</router-link
          >
          <router-link active-class="active" v-if="!isAuth" to="/register"
            >Inscription</router-link
          >
          <router-link active-class="active" v-if="!isAuth" to="/login"
            >Connexion</router-link
          >
          <router-link active-class="active" v-if="isAuth" to="/logout"
            >Déconnexion</router-link
          >
        </li>
      </ul>
    </section>
  </div>
</template>

<style lang="scss" scoped>
.overlay {
  background: black;
  width: 100%;
  min-height: 100vh;
  height: 100%;
  z-index: 1;
  position: absolute;
  opacity: 0.4;

  @media (min-width: 1205px) {
    display: none !important;
  }
}

.menu {
  position: absolute;
  background: white;
  display: flex;
  flex-direction: column;

  @media (min-width: 640px) {
    align-items: center;
  }

  width: 100%;
  top: 9.9rem;
  padding: 3.4rem 0 3.5rem 0;
  z-index: 2;
  opacity: 1;
  max-height: 75vh;

  @media (min-width: 1205px) {
    display: none !important;
  }
}

.links {
  .navbar__desktop-menu__link {
    a {
      color: black;
      font-weight: 700;
      font-size: 1.3rem;
      line-height: 2.5rem;
      letter-spacing: 0.2rem;
      text-transform: uppercase;
      margin-left: 3.4rem;
      transition: all 0.3s ease;

      &:hover {
        color: rgba(216, 125, 74, 1);
      }
    }

    @media (max-width: 640px) {
      display: flex;
      flex-direction: column;
    }
  }
}

.showElement {
  display: flex;
}

.hideElement {
  display: none;
}
</style>
