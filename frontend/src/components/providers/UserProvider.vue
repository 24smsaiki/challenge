<template>
  <slot :logout="logout" :isAuth="isAuth"></slot>
</template>

<script setup>
import { ref, reactive, provide } from "vue";
import AuthLogic from "../../logics/AuthLogic";
import router from "../../router";

const login = (form) => {
  return AuthLogic.login({ ...form })
    .then((data) => {
      isAuth.value = !isAuth.value;
      user.value = data;
    })
    .catch((error) => {
      console.error(error);
    });
};

const logout = () => {
  AuthLogic.logout();
  isAuth.value = !isAuth.value;
  router.push({ name: "home" });
};

const register = (form) => {
  return AuthLogic.register({ ...form });
};

let isAuth = ref(AuthLogic.isAuth());
const user = reactive({});

provide("ProviderLogout", logout);
provide("ProviderIsAuth", isAuth);
provide("ProviderLogin", login);
provide("ProviderRegister", register);
</script>
