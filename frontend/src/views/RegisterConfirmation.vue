<script setup>
import router from "../router/Router";
import AuthLogic from "../logics/AuthLogic";
import { createToast } from "mosha-vue-toastify";

const redirectToLogin = () => {
  router.push("/login");
};

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

const token = router?.currentRoute?.value?.params?.token;

if (token) {
  AuthLogic.activateAccount(token).then((res) => {
    if (res.status === 201) {
      router.push("/login");
      setToast("Votre compte a bien été activé.", "success");
    }
  });
} else {
  router.push("/login");
  setToast("Une erreur est survenue.", "danger");
}
</script>

<template>
  <div class="container">
    <h1>Confirmation de validation d'e-mail</h1>
    <p>Merci d'avoir validé votre e-mail.</p>
    <p>
      Votre e-mail a bien été confirmé et vous pouvez maintenant accéder à
      toutes les fonctionnalités de notre site.
    </p>
    <button class="btn mt-4" @click="redirectToLogin">Se connecter</button>
  </div>
</template>

<style lang="scss">
.container {
  text-align: center;
  max-width: 600px;
  margin: 0 auto;
  background-color: #fff;
  border-radius: 5px;
  padding: 20px;
  margin-top: 20px;
}

p {
  font-size: 16px;
}

h1 {
  font-size: 24px;
  text-align: center;
  margin-bottom: 30px;
}

.btn {
  padding: 10px 20px;
  background-color: #808080;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;

  &:hover {
    background-color: #666666;
  }
}
</style>
