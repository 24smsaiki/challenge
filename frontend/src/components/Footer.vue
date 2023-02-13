<script setup>
import { inject } from "vue";
const isAuth = inject("ProviderIsAuth");
const scrollToTop = () => window.scrollTo(0, 0);
</script>

<template>
  <footer class="footer">
    <div class="footer__content">
      <div class="footer__content__deco-bar"></div>
      <div class="footer__content__first-line">
        <span class="footer__content__first-line__logo">GadgetMarket</span>
        <ul class="footer__content__first-line__link-list">
          <li class="footer__content__first-line__link-list__link">
            <router-link active-class="active" @click="scrollToTop" to="/"
              >Accueil</router-link
            >
          </li>
          <li
            v-if="isAuth"
            class="footer__content__first-line__link-list__link"
          >
            <router-link active-class="active" to="/products"
              >Produits</router-link
            >
          </li>
          <li
            v-if="isAuth"
            class="footer__content__first-line__link-list__link"
          >
            <router-link active-class="active" to="/account"
              >Compte</router-link
            >
          </li>
          <li
            v-if="isAuth"
            class="footer__content__first-line__link-list__link"
          >
            <router-link active-class="active" to="/">Panier</router-link>
          </li>
          <li
            v-if="!isAuth"
            class="footer__content__first-line__link-list__link"
          >
            <router-link active-class="active" to="/register"
              >Inscription</router-link
            >
          </li>
          <li
            v-if="!isAuth"
            class="footer__content__first-line__link-list__link"
          >
            <router-link active-class="active" to="/login"
              >Connexion</router-link
            >
          </li>

          <li
            v-if="isAuth"
            class="footer__content__first-line__link-list__link"
          >
            <router-link active-class="active" to="/logout"
              >Déconnexion</router-link
            >
          </li>
          <li
            v-if="!isAuth"
            class="footer__content__first-line__link-list__link"
          >
            <router-link to="/join-us">Devenir vendeur</router-link>
          </li>
        </ul>
      </div>
      <p class="footer__content__text">
        GadgetMarket est une solution pour répondre à vos besoins. Nous sommes
        un petite équipe de mélomanes et de spécialistes qui se consacrent à
        vous aidant à tirer le meilleur parti de nos produits. Venez visiter
        notre démo installation - nous sommes ouverts 7 jours sur 7.
      </p>
      <div class="footer__content__copyright-section">
        <p class="footer__content__copyright-section__copyright-text">
          Copyright 2023. Tous droits réservés
        </p>
      </div>
    </div>
  </footer>
</template>

<style lang="scss" scoped>
.footer {
  background: black;
  display: flex;
  flex-direction: column;
  align-items: center;

  a.active {
    color: #d87d4a;
  }

  .footer__content__first-line__logo {
    font-size: 2.4rem;
    margin-bottom: 2.4rem;
  }

  @media (min-width: 768px) {
    align-items: flex-start;
    padding: 0 4rem 22px 4rem;
  }

  * {
    color: white;
    text-align: center;
  }

  &__content {
    display: flex;
    align-items: center;
    flex-direction: column;

    @media (min-width: 768px) {
      margin: 0 auto;
      width: 68.9rem;
      align-items: flex-start;
    }

    @media (min-width: 1205px) {
      width: 111rem;
    }

    &__deco-bar {
      width: 10.1rem;
      height: 0.4rem;
      border-top: 0.4rem solid #d87d4a;
    }

    &__first-line {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;

      @media (min-width: 768px) {
        align-items: flex-start;
      }

      @media (min-width: 1205px) {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        margin-top: 5rem;
      }

      &__logo {
        margin: 4.8rem 0;

        @media (min-width: 768px) {
          margin: 5.6rem 0 3.2rem 0;
        }

        @media (min-width: 1205px) {
          margin: 0;
        }
      }

      &__link-list {
        @media (min-width: 768px) {
          display: flex;
          align-items: center;
        }

        &__link {
          margin-bottom: 1.6rem;
          font-weight: 700;
          font-size: 1.3rem;
          line-height: 2.5rem;
          letter-spacing: 0.2rem;
          text-transform: uppercase;

          * {
            transition: all 0.3s ease;
          }

          @media (min-width: 768px) {
            margin: 0;
            margin-right: 3.4rem;
          }

          &:hover * {
            color: #d87d4a;
          }

          &:last-child {
            margin-bottom: 0;
            margin-right: 0;
          }
        }
      }
    }

    &__text {
      margin: 4.8rem auto;
      color: #808080;
      font-weight: 500;
      font-size: 1.5rem;
      line-height: 2.5rem;
      width: 32.7rem;

      @media (min-width: 768px) {
        text-align: left;
        margin: 3.2rem 0 8rem 0;
        width: 68.9rem;
      }

      @media (min-width: 1205px) {
        width: 54rem;
      }
    }

    &__copyright-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 10px;

      @media (min-width: 768px) {
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
      }

      &__copyright-text {
        color: #878787;
        font-weight: 700;
        font-size: 1.5rem;
        line-height: 2.5rem;
      }
    }
  }
}
</style>
