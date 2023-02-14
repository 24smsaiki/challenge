<script setup>
import { ref, reactive, inject } from "vue";
import router from "../../router/Router";
import { createToast } from "mosha-vue-toastify";

const register = inject("ProviderRegister");
const isLoading = ref(false);

const redirectToHome = () => router.push({ name: "Home" });
const form = reactive({
  email: "",
  password: "",
  passwordConfirmation: "",
  firstname: "",
  lastname: "",
});

const error = ref("");

const onSubmit = async () => {
  return await register(form).then(() => {
    createToast("Un email de vérification a été envoyé.", {
      type: "success",
      position: "top-right",
      timeout: 3000,
    });
    redirectToHome();
  }).catch((err) => {
    err.value = err?.response?.data?.errors[0].message;
  }).finally(() => {
    isLoading.value = false;
  });
};
</script>

<template>
  <form @submit.prevent="onSubmit">
    <h3>Inscription</h3>
    <label for="email">Adresse mail</label>
    <input
      type="text"
      placeholder="Adresse mail"
      id="email"
      v-model="form.email"
    />
    <label for="firstname">Prénom </label>
    <input
      type="text"
      placeholder="Prénom"
      id="firstname"
      v-model="form.firstname"
    />
    <label for="lastname">Nom</label>
    <input
      type="text"
      placeholder="Nom"
      id="lastname"
      v-model="form.lastname"
    />

    <label for="password">Mot de passe</label>
    <input
      type="password"
      placeholder="Mot de passe"
      id="password"
      v-model="form.password"
    />

    <label for="password">Confirmation</label>
    <input
      type="password"
      placeholder="Confirmer le mot de passe"
      id="password"
      v-model="form.passwordConfirmation"
    />

    <button type="submit">S'enregistrer</button>
    <div class="error" v-if="error">{{ error }}</div>
    <div class="signin d-flex mt-2">
      <p>Vous avez déjà un compte ?</p>
      <router-link active-class="active" to="/login" class="underline ml-1"
        >Connectez-vous</router-link
      >
    </div>
  </form>
</template>

<style scoped>
.d-flex {
  display: flex;
}

.mt-2 {
  margin-top: 10px;
}

.ml-1 {
  margin-left: 5px;
}

.underline {
  text-decoration: underline;
}

.error {
  color: red;
  font-size: 14px;
  margin: 20px 20px;
  text-align: center;
}

*,
*:before,
*:after {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  background-color: #080710;
}

form {
  width: 400px;
  background-color: black;
  margin: 20px auto;
  color: #ffffff;
  border-radius: 10px;
  border: 2px solid rgba(255, 255, 255, 0.1);
  padding: 50px 35px;
}

form * {
  font-family: "Poppins", sans-serif;
  color: #ffffff;
  letter-spacing: 0.5px;
  outline: none;
  border: none;
}

form h3 {
  font-size: 32px;
  font-weight: 500;
  line-height: 42px;
  text-align: center;
}

label {
  display: block;
  margin-top: 30px;
  font-size: 16px;
  font-weight: 500;
}

input {
  display: block;
  height: 50px;
  width: 100%;
  background-color: rgba(255, 255, 255, 0.07);
  border-radius: 3px;
  padding: 0 10px;
  margin-top: 8px;
  font-size: 14px;
  font-weight: 300;
}

::placeholder {
  color: #e5e5e5;
}

button {
  margin-top: 25px;
  width: 100%;
  background-color: #ffffff;
  color: #080710;
  padding: 15px 0;
  font-size: 18px;
  font-weight: 600;
  border-radius: 5px;
  cursor: pointer;
}
</style>
