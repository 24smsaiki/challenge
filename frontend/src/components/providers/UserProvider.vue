<template>
  <slot :logout="logout" :isAuth="isAuth"></slot>
</template>

<script setup>
import { ref, reactive, provide } from "vue";
import AuthLogic from "../../logics/AuthLogic";
import router from "../../router/Router";

let isAuth = ref(AuthLogic.isAuth());
const user = reactive({});

const login = (form) => {
  return AuthLogic.login({ ...form }).then((data) => {
    isAuth.value = !isAuth.value;
    user.value = data;
    return user.value;
  });
};

const logout = () => {
  AuthLogic.logout();
  isAuth.value = !isAuth.value;
  router.push({ name: "Home" });
};

const register = (form) => {
  return AuthLogic.register({ ...form });
};

provide("ProviderLogout", logout);
provide("ProviderIsAuth", isAuth);
provide("ProviderLogin", login);
provide("ProviderRegister", register);
provide("ProviderUser", user)
</script>
