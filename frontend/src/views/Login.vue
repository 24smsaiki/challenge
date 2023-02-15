<script setup>
import { ref, reactive, inject } from "vue";
import router from "../router/Router";
import Header from "../components/Header.vue";
import LocalStorage from "../services/LocalStorage";

const form = reactive({
  email: "",
  password: "",
});

const error = ref("");
const isLoading = ref(false);
const login = inject("ProviderLogin");
let user = null

const redirectToHome = () => router.push({ name: "Home" });

const isAdmin = () => {
  user = LocalStorage.get("user");

  if (user?.roles.includes("ROLE_ADMIN")) {
    return true;
  } else {
    return false;
  }
};

const onSubmit = async () => {
  isLoading.value = true;
  try {
    await login(form).then((res) => {
      if(isAdmin()) {
        router.push({ name: "AdminDashboard" });
      } else {
        redirectToHome();
      }
    });
  } catch (err) {
    if (err.status === 401 && err.message === "Invalid credentials.") {
      error.value = "Vérifiez vos identifiants";
    } else if (err.status === 401) {
      error.value = err.message;
    } else {
      error.value = "Une erreur est survenue";
    }
  }  finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <div id="login">
    <form @submit.prevent="onSubmit">
      <h3>Connexion</h3>
      <label for="email">Adresse mail</label>
      <input
        type="text"
        placeholder="Adresse mail"
        id="email"
        v-model="form.email"
      />
      <label for="password">Mot de passe</label>
      <input
        type="password"
        placeholder="Mot de passe"
        id="password"
        v-model="form.password"
      />
      <button type="submit">Se connecter</button>
      <div class="social">
        <div class="error" v-if="error">{{ error }}</div>
      </div>
      <div class="signup d-flex mt-2">
        <p>Vous n'avez pas de compte ?</p>
        <router-link active-class="active" to="/register" class="underline ml-1"
          >Inscrivez-vous</router-link
        >
      </div>
    </form>
  </div>
</template>

<style scoped lang="scss">
#login {
  .signup {
    margin-top: 20px;
    text-align: center;
    font-size: 14px;
  }

  .error {
    color: red;
    font-size: 12px;
    margin-top: 10px;
    text-align: center;
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

  ::placeholder {
    color: #e5e5e5;
  }

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
}
</style>
