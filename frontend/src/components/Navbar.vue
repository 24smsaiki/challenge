<script setup>
import { inject, defineEmits } from "vue";

const isAuth = inject("ProviderisAuth");
const logout = inject("Providerlogout");
const onLogout = () => {
  logout();
};

defineEmits(["toggle-menu-show"]);
</script>

<template>
  <nav class="navbar">
    <button
      class="navbar__mobile-menu-btn"
      @click="$emit('toggle-menu-show', 'menu')"
    ></button>
    <div class="d-flex align-center">
      <span class="navbar__content__first-line__logo">GadgetMarket</span>
      <ul class="navbar__desktop-menu ml-30">
        <li class="navbar__desktop-menu__link">
          <router-link to="/">Accueil</router-link>
          <router-link to="/">Produits</router-link>
          <router-link v-if="isAuth" to="/account">Compte</router-link>
          <router-link to="/">Contact</router-link>
          <router-link v-if="!isAuth" to="/register">Inscription</router-link>
          <router-link v-if="!isAuth" to="/login">Connexion</router-link>
          <a v-if="isAuth" @click="onLogout">Déconnexion</a>
        </li>
      </ul>
    </div>
    <button
      v-if="isAuth"
      class="navbar__cart-btn"
      @click="$emit('toggle-menu-show', 'cart')"
    ></button>
  </nav>
</template>

<style lang="scss" scoped>
.d-flex {
  display: flex;
}

.align-center {
  align-items: center;
}

.ml-30 {
  margin-left: 30px;
}

.navbar {
  background: transparent;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 3.2rem 2.4rem;
  position: relative;
  border-bottom: 0.1rem solid #353535;
  z-index: 3;

  .navbar__content__first-line__logo {
    color: #fff;
    font-size: 2.4rem;
  }

  @media (min-width: 768px) {
    padding: 3.2rem 0;
    margin: 0 auto;
    width: 68.9rem;
  }

  @media (min-width: 1205px) {
    width: 111rem;
  }

  button {
    border: none;
  }

  &__mobile-menu-btn {
    background: url("../assets/shared/tablet/icon-hamburger.svg");
    width: 1.6rem;
    height: 1.5rem;

    @media (min-width: 1205px) {
      display: none;
    }
  }

  &__desktop-menu {
    margin-left: 19.7rem;
    display: none;

    @media (min-width: 1205px) {
      display: flex;
    }

    &__link {
      a {
        color: white;
        font-weight: 700;
        font-size: 1.3rem;
        line-height: 2.5rem;
        letter-spacing: 0.2rem;
        text-transform: uppercase;
        margin-left: 3.4rem;
        transition: all 0.3s ease;

        &:first-child {
          margin-left: 0;
        }

        &:hover {
          color: rgba(216, 125, 74, 1);
        }
      }
    }
  }

  &__cart-btn {
    background: url("../assets/shared/desktop/icon-cart.svg");
    width: 2.3rem;
    height: 2rem;
  }
}
</style>
