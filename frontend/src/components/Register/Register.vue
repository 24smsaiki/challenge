<script setup>
import { ref, reactive, inject } from "vue";
import router from "../../router/Router";

const register = inject("ProviderRegister");
const redirectToHome = () => {
  router.push({ name: "Login" });
};
const isLoading = ref(false);

const form = reactive({
  email: "",
  password: "",
  plainPassword: "",
});

const error = ref("");

const onSubmit = async () => {
  try {
    isLoading.value = true;
    await register(form);
    error.value = "";
    redirectToHome();
  } catch (err) {
    error.value = err?.response?.data?.errors[0]?.message;
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <form @submit.prevent="onSubmit">
    <h3>Inscription</h3>
    <label for="email">Email</label>
    <input type="text" placeholder="Email" id="email" v-model="form.email" />

    <label for="password">Password</label>
    <input
      type="password"
      placeholder="Password"
      id="password"
      v-model="form.password"
    />

    <label for="password">Confirm password</label>
    <input
      type="password"
      placeholder="Confirm password"
      id="password"
      v-model="form.plainPassword"
    />

    <button type="submit">Log In</button>
    <div class="error" v-if="error">{{ error }}</div>
    <!-- Déjà inscrit ? -->
    <div class="signin">
      <p>Vous avez déjà un compte ?</p>
      <router-link to="/login" class="underline">Inscrivez-vous</router-link>
    </div>
  </form>
</template>

<style scoped>
.underline {
  text-decoration: underline;
}
.signup {
  margin-top: 20px;
  text-align: center;
  font-size: 14px;
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
.background {
  width: 430px;
  height: 520px;
  position: absolute;
  transform: translate(-50%, -50%);
  left: 50%;
  top: 50%;
}
.background .shape {
  height: 200px;
  width: 200px;
  position: absolute;
  border-radius: 50%;
}
.shape:first-child {
  background: linear-gradient(#1845ad, #23a2f6);
  left: -80px;
  top: -80px;
}
.shape:last-child {
  background: linear-gradient(to right, #ff512f, #f09819);
  right: -30px;
  bottom: -80px;
}
form {
  /* height: 520px; */
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
  margin-top: 50px;
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
