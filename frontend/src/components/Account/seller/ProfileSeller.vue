<script setup>
import { ref } from "vue";
import { createToast } from "mosha-vue-toastify";
import ProfileLogic from "../../../logics/ProfileLogic";

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
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
  });
}

const getSellerInformation = () => {
  const user = JSON.parse(localStorage.getItem("app-user"));
  Promise.all([
    ProfileLogic.getUserInformation(user?.id),
    ProfileLogic.getShopInformation(),
  ])
    .then((res) => {
      if (res[0].status === 200 && res[1].status === 200) {
        if (res[0]?.data && res[1]?.data) {
          // user information
          username.value = `${res[0].data.firstname} ${res[0].data.lastname}`;
          firstName.value = res[0].data.firstname;
          lastName.value = res[0].data.lastname;

          // shop information
          shopName.value = res[1].data[0].shopLabel;
          shopDescription.value = res[1].data[0].shopDescription;
          shopEmail.value = res[1].data[0].shopEmailContact;
          email.value = res[1].data[0].shopEmailContact;
          shopPhone.value = res[1].data[0].shopPhoneContact;
        }
      }
    })
    .catch(() => {
      setToast(
        "Une erreur est survenue lors du chargement des informations",
        "danger"
      );
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
            placeholder="Nom d'utilisateur"
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="username"
            type="text"
            :value="username"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="lastName">Nom</label>
          <input
            disabled
            placeholder="Nom"
            readonly
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="lastName"
            type="text"
            :value="lastName"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="firstName">Prénom</label>
          <input
            disabled
            readonly
            placeholder="Prénom"
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="firstName"
            type="text"
            :value="firstName"
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
            placeholder="Nom"
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
            placeholder="Adresse email"
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopEmail"
            type="email"
            :value="shopEmail"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="shopPhone">Téléphone</label>
          <input
            disabled
            readonly
            placeholder="Téléphone"
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopPhone"
            type="text"
            :value="shopPhone"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="shopDescription">Description</label>
          <textarea
            disabled
            readonly
            placeholder="Description"
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
