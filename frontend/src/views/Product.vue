<script setup>
import { ref, defineEmits, computed, onMounted, watch } from "vue";
import Header from "../components/Product/Header.vue";
// import ProductPageNavigation from "../components/ProductPageNavigation.vue";
import router from "../router/Router";
import OthersCard from "../components/Product/OthersCard.vue";
import { useProductStore } from "../stores/ProductStore.js";
import { useCartStore } from "../stores/CartStore.js";
import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css'


// define emits
const emit = defineEmits(["toggle-menu-show", "add-to-cart"]);

const cartStore = useCartStore();
const productStore = useProductStore();
const total = ref(1);
const justAdded = ref(false);
const products = productStore.products;




const currentProduct = computed(() => {

  if(products.length === 0) return null;
  return products.find((product) => product.slug === router.currentRoute._value.params.product);
  
});

const increaseTotal = () => {
     total.value++;
    };
const decreaseTotal = () => {
     if(total.value > 1) {
       total.value--;
     }
    };
const addToCartHandler = () => {
      justAdded.value = true;
      const toast = createToast('Product ajouté au panier', {
        position: 'top-right',
        timeout: 7000,
        close: true,
        type: 'success',
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: false,
        closeButton: 'button',
        icon: true,
        rtl: false
      });
     const data = {
      productId: currentProduct.value.id,
      addedQuantity: total.value,
     };
      cartStore.addProduct(data);
      emit("add-to-cart", data);
    };

const resetTotal = () => {
     total.value = 1;
     justAdded.value = false;
    }
    
const editedText = computed(() => {
  const paragraphs = [];
      let myString = currentProduct.value.features;
      while (myString.includes("\n\n")) {
        let index = myString.indexOf("\n\n");
        paragraphs.push(myString.slice(0, index));
        myString = myString.slice(index + 2);
      }
      if (paragraphs.length > 0) {
        paragraphs.push(myString);
      } else {
        paragraphs.push(currentProduct.features);
      }
      return paragraphs;
    });
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)" />
  <main>
    <p class="back-link" @click="$router.back()">Go back</p>
    <section class="overview">
      <img
        :src="currentProduct.image"
        :alt="currentProduct.title"
        class="overview__image"
      />
      <div class="overview__text">
        <p class="overview__text__tag" v-show="currentProduct.new">
          {{ currentProduct.name }}
        </p>
        <h2 class="overview__text__title">{{ currentProduct.title }}</h2>
        <p class="overview__text__description">
          {{ currentProduct.description }}
        </p>
        <p class="overview__text__price">{{ currentProduct.price }} €</p>
        <div class="overview__text__btn-section">
          <div class="overview__text__btn-section__number">
            <button
              class="overview__text__btn-section__number__less"
              @click="decreaseTotal"
            >
              -
            </button>
            <p class="overview__text__btn-section__number__value">
              {{ total }}
            </p>
            <button
              class="overview__text__btn-section__number__more"
              @click="increaseTotal"
            >
              +
            </button>
          </div>
          <button
            :class="[
              'overview__text__btn-section__btn',
              'default-btn',
              justAdded ? 'just-added' : '',
            ]"
            
            @click="addToCartHandler"
          >
           Ajouter au panier
          </button>
        </div>
      </div>
    </section>
    <section class="details">
      <div class="details__features">
        <h3 class="details__features__heading">Features</h3>
        <p
          class="details__features__text"
          v-for="paragraph in editedText"
          :key="paragraph"
        >
          {{ paragraph }}
        </p>
      </div>
      <div class="details__box">
        <h3 class="details__box__heading">In the box</h3>
        <ul class="details__box__list">
          <li
            class="details__box__list__item"
            v-for="item in currentProduct.includes"
            :key="item.item"
          >
            <p class="details__box__list__item__quantity">
              {{ item.quantity }}x
            </p>
            <p class="details__box__list__item__name">{{ item.item }}</p>
          </li>
        </ul>
      </div>
    </section>
    <section class="gallery">
      <div class="gallery__left">
        <img
          :src="currentProduct.gallery.first"
          :alt="`${currentProduct.title} presentation image`"
          class="gallery__left__first"
        />
        <img
          :src="currentProduct.gallery.second"
          :alt="`${currentProduct.title} presentation image`"
          class="gallery__left__second"
        />
      </div>
      <div class="gallery__right">
        <img
          :src="currentProduct.gallery.third"
          :alt="`${currentProduct.title} presentation image`"
        />
      </div>
    </section>
    <section class="others">
      <h4 class="others__heading">You may also like</h4>
      <div class="others__container">
        <OthersCard
          v-for="product in currentProduct.others"
          :key="product.id"
          :product="product"
          @reset-total="resetTotal"
        />
      </div>
    </section>
    <ProductNavigation />
  </main>
</template>

<style lang="scss" scoped>
main {
  width: 32.7rem;
  margin: 0 auto;
  @media (min-width: 768px) {
    width: 68.9rem;
  }
  @media (min-width: 1205px) {
    width: 111rem;
  }
}
.back-link {
  font-size: 1.5rem;
  line-height: 2.5rem;
  font-weight: 500;
  color: #7d7d7d;
  margin: 1.6rem 0 2.4rem 0;
  display: block;
  cursor: pointer;
  transition: all 0.3s ease;
  &:hover {
    color: rgba(216, 125, 74, 1);
  }
  @media (min-width: 768px) {
    margin-top: 3.3rem;
  }
  @media (min-width: 1205px) {
    margin-top: 7.9rem;
  }
}
.overview {
  margin: 2.4rem auto 0 auto;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  @media (min-width: 768px) {
    flex-direction: row;
  }
  @media (min-width: 1205px) {
    margin-top: 5.6rem;
  }
  & * {
    text-align: left;
  }
  &__image {
    width: 100%;
    border-radius: 0.8rem;
    object-fit: cover;
    object-position: center;
    @media (min-width: 768px) {
      height: 48rem;
      width: 28.1rem;
    }
    @media (min-width: 1205px) {
      width: 54rem;
      height: 56rem;
    }
  }
  &__text {
    margin-top: 3.2rem;
    @media (min-width: 768px) {
      width: 33.95rem;
      margin-top: 0;
      margin-left: 6.9rem;
    }
    @media (min-width: 1205px) {
      margin: 0;
      margin-left: 12.5rem;
      width: 44.5rem;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      * {
        text-align: left;
      }
    }
    &__tag {
      font-size: 1.4rem;
      font-weight: 400;
      line-height: 1.912rem;
      letter-spacing: 1rem;
      text-transform: uppercase;
      color: rgba(216, 125, 74, 1);
    }
    &__title {
      margin: 2.4rem 0;
      font-weight: 700;
      font-size: 2.8rem;
      line-height: 3.825rem;
      letter-spacing: 0.1rem;
      text-transform: uppercase;
      @media (min-width: 768px) {
        font-size: 4rem;
        line-height: 4.4rem;
        letter-spacing: 0.143rem;
      }
    }
    &__description {
      margin-bottom: 2.4rem;
      font-weight: 500;
      font-size: 1.5rem;
      line-height: 2.5rem;
      color: #8d8d8d;
    }
    &__price {
      font-weight: 700;
      font-size: 1.8rem;
      line-height: 2.459rem;
      letter-spacing: 0.129rem;
      margin-bottom: 3.1rem;
    }
    &__btn-section {
      display: flex;
      align-items: center;
      &__number {
        display: flex;
        align-items: center;
        background: #f1f1f1;
        padding: 1.5rem;
        width: 12rem;
        justify-content: space-between;
        margin-right: 1.6rem;
        & * {
          background: none;
          border: none;
          font-weight: 700;
          font-size: 1.3rem;
          line-height: 1.776rem;
          letter-spacing: 0.1rem;
        }
        & button {
          color: #b5b5b5;
          transition: all 0.3s ease;
          &:hover {
            color: rgba(216, 125, 74, 1);
          }
        }
      }
    }
  }
}
.details {
  margin: 8.8rem auto 11.3rem auto;
  width: 100%;
  @media (min-width: 1205px) {
    display: flex;
    align-items: flex-start;
  }
  h3 {
    text-transform: uppercase;
    font-weight: 700;
    font-size: 2.4rem;
    line-height: 3.6rem;
    letter-spacing: 0.086rem;
    @media (min-width: 768px) {
      font-size: 3.2rem;
      letter-spacing: 0.114rem;
    }
  }
  &__features {
    @media (min-width: 1205px) {
      width: 63.5rem;
    }
    &__text {
      margin-top: 2.4rem;
      font-weight: 500;
      font-size: 1.5rem;
      line-height: 2.5rem;
      color: #7d7d7d;
      @media (min-width: 1205px) {
        margin-top: 3.2rem;
      }
    }
  }
  &__box {
    margin-top: 11.3rem;
    @media (min-width: 768px) {
      display: flex;
      align-items: flex-start;
    }
    @media (min-width: 1205px) {
      width: 35rem;
      margin: 0;
      margin-left: 12.5rem;
      display: block;
    }
    &__heading {
      width: 35rem;
    }
    &__list {
      margin-top: 2.4rem;
      @media (min-width: 768px) {
        margin-top: 0;
      }
      @media (min-width: 1205px) {
        margin-top: 3.2rem;
      }
      * {
        font-size: 1.5rem;
        line-height: 2.5rem;
      }
      &__item {
        display: flex;
        align-items: center;
        &__quantity {
          font-weight: 700;
          color: rgba(216, 125, 74, 1);
        }
        &__name {
          font-weight: 500;
          margin-left: 2.1rem;
          color: #7d7d7d;
          text-transform: capitalize;
        }
      }
    }
  }
}
.gallery {
  @media (min-width: 768px) {
    display: flex;
  }
  img {
    width: 100%;
    border-radius: 0.8rem;
    margin: 1rem 0;
    object-fit: cover;
    object-position: center;
    @media (min-width: 768px) {
      margin: 0;
    }
  }
  &__left {
    @media (min-width: 768px) {
      width: 27.7rem;
    }
    @media (min-width: 1205px) {
      width: 44.5rem;
    }
    img {
      height: 17.4rem;
      @media (min-width: 1205px) {
        height: 28rem;
      }
    }
    &__first {
      margin-top: 0 !important;
      @media (min-width: 768px) {
        margin-bottom: 2rem !important;
      }
      @media (min-width: 1205px) {
        margin-bottom: 3.2rem !important;
      }
    }
  }
  &__right {
    img {
      margin-bottom: 0 !important;
      height: 36.8rem;
      @media (min-width: 768px) {
        width: 39.5rem;
        margin-left: 1.8rem;
      }
      @media (min-width: 1205px) {
        width: 64.5rem;
        height: 59.2rem;
        margin-left: 3rem;
      }
    }
  }
}
.others {
  margin-top: 12rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: calc(12rem - 5.2rem);
  &__heading {
    text-align: center;
    text-transform: uppercase;
    font-weight: 700;
    font-size: 2.4rem;
    line-height: 3.6rem;
    letter-spacing: 0.086rem;
    margin-bottom: 4rem;
    @media (min-width: 768px) {
      font-size: 3.2rem;
      line-height: 3.6rem;
      letter-spacing: 0.114rem;
      margin-bottom: 5.6rem;
    }
  }
  &__container {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    @media (min-width: 768px) {
      flex-direction: row;
      align-items: flex-start;
    }
  }
}
.just-added {
  background: #f6af85;
}
</style>
