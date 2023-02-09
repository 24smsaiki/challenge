<script setup>
import { ref } from "vue";
import axios from "axios";

const username = ref("");
const firstName = ref("");
const lastName = ref("");
const email = ref("");

const setUserData = () => {
  axios
    .get("https://localhost/users")
    .then((response) => response)
    .then((res) => {
      const user = res?.data["hydra:member"][0];
      username.value = `${user.firstname} ${user.lastname}`;
      firstName.value = user.firstname;
      lastName.value = user.lastname;
      email.value = user.email;
    })
    .catch((error) => {
      console.log(error);
    });
};

setUserData();
</script>

<template>
  <form class="profile-form">
    <div class="ml-2 mb-4 mr-2">
      <label class="block font-bold mb-2" for="username"
        >Nom d'utilisateur</label
      >
      <input
        disabled
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="username"
        type="text"
        :value="username"
      />
    </div>
    <div class="ml-2 mb-4 mr-2">
      <label class="block font-bold mb-2" for="firstName">Prénom</label>
      <input
        disabled
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="firstName"
        type="text"
        :value="firstName"
      />
    </div>
    <div class="ml-2 mb-4 mr-2">
      <label class="block font-bold mb-2" for="lastName">Nom</label>
      <input
        disabled
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        id="lastName"
        type="text"
        :value="lastName"
      />
    </div>
    <div>
      <label class="block font-bold mb-2" for="email">Adresse email</label>
      <input
        disabled
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
        id="email"
        type="email"
        :value="email"
      />
    </div>
  </form>
</template>

<style scoped>
.profile-form {
  font-size: 20px;
  height: 100%;
  display: flex;
  flex-direction: column;
  overflow: auto;
}
</style>
