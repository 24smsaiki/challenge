<script setup>
import { ref } from "vue";
import { createToast } from "mosha-vue-toastify";
import ProfileLogic from "../../../logics/Account/seller/ProfileLogic";

const username = ref("");
const firstName = ref("");
const lastName = ref("");
const email = ref("");
const shopName = ref("");
const shopDescription = ref("");
const shopEmail = ref("");
const shopPhone = ref("");

function setToast(message, type) {
  createToast(message, {
    position: "top-right",
    timeout: 5000,
    close: true,
    type: type,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
  });
}

const getSellerInformation = () => {
  const sellerInformation = ProfileLogic.getSellerInformation()
    .then((response) => {
      if (response.status === 200) {
        return response.data;
      }
    })
    .catch(() =>
      setToast(
        "Une erreur est survenue lors du chargement du vendeur",
        "danger"
      )
    );

  const shopInformation = ProfileLogic.getShopInformation()
    .then((response) => {
      if (response.status === 200) {
        return response.data;
      }
    })
    .catch(() =>
      setToast(
        "Une erreur est survenue lors du chargement de la boutique",
        "danger"
      )
    );

  Promise.all([sellerInformation, shopInformation]).then((values) => {
    if (values.length) {
      // user information
      if (values[0].length) {
        const user = values[0][0];
        username.value = `${user.firstname} ${user.lastname}`;
        firstName.value = user.firstname;
        lastName.value = user.lastname;
        email.value = user.email;
      }

      // shop information
      if (values[1].length) {
        const shop = values[1][0];
        shopName.value = shop.shop_label;
        shopDescription.value = shop.shop_description;
        shopEmail.value = shop.shop_email_contact;
        shopPhone.value = shop.shop_phone_contact;
      }
    }
  });
};

getSellerInformation();
</script>

<template>
  <form class="profile-form">
    <legend>
      <span class="font-bold">Informations du vendeur</span>
      <div class="seller-bloc mt-4">
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="username">Nom d'utilisateur</label>
          <input
            disabled
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="username"
            type="text"
            :value="username"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="firstName">Prénom</label>
          <input
            disabled
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="firstName"
            type="text"
            :value="firstName"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="lastName">Nom</label>
          <input
            disabled
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="lastName"
            type="text"
            :value="lastName"
          />
        </div>
        <div>
          <label class="block mb-2" for="email">Adresse email</label>
          <input
            disabled
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="email"
            type="email"
            :value="email"
          />
        </div>
      </div>
    </legend>
    <legend class="mt-4">
      <span class="font-bold">Informations de la boutique</span>
      <div class="shop-bloc mt-4">
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="shopName">Nom</label>
          <input
            disabled
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopName"
            type="text"
            :value="shopName"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="shopEmail">Adresse email</label>
          <input
            disabled
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopEmail"
            type="email"
            :value="shopEmail"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="shopPhone">Numéro de téléphone</label>
          <input
            disabled
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopPhone"
            type="text"
            :value="shopPhone"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="shopDescription"
            >Description de la boutique</label
          >
          <textarea
            disabled
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopDescription"
            type="text"
            :value="shopDescription"
          ></textarea>
        </div>
      </div>
    </legend>
  </form>
</template>

<style scoped lang="scss">
.profile-form {
  font-size: 20px;
  height: 100%;
  overflow: auto;

  input {
    border-radius: 5px;
  }

  .seller-bloc,
  .shop-bloc {
    padding: 10px;
    border: 1px solid #e2e8f0;
    border-radius: 5px;
  }
}
</style>
