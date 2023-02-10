<script setup>
import { ref } from "vue";
import { createToast } from "mosha-vue-toastify";
import ProfileLogic from "../../../logics/Account/client/ProfileLogic";

const username = ref("");
const firstName = ref("");
const lastName = ref("");
const email = ref("");

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

const getUserData = () => {
  ProfileLogic.getUser()
    .then((response) => {
      if (response.status === 200) {
        const user = response?.data[0];
        username.value = `${user.firstname} ${user.lastname}`;
        firstName.value = user.firstname;
        lastName.value = user.lastname;
        email.value = user.email;
      }
    })
    .catch(() =>
      setToast("Une erreur est survenue lors du chargement", "danger")
    );
};

getUserData();
</script>

<template>
  <form class="profile-form">
    <div class="ml-2 mb-5 mr-2">
      <label class="block font-bold mb-2" for="username"
        >Nom d'utilisateur</label
      >
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
      <label class="block font-bold mb-2" for="firstName">Prénom</label>
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
      <label class="block font-bold mb-2" for="lastName">Nom</label>
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
      <label class="block font-bold mb-2" for="email">Adresse email</label>
      <input
        disabled
        readonly
        class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
        id="email"
        type="email"
        :value="email"
      />
    </div>
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
}
</style>
