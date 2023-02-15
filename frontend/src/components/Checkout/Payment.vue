<script setup>
import Header from "../Header.vue";
import router from "../../router/Router";
const goToPanier = () => router.push("/checkout");
</script>

<template>
  <Header></Header>
  <div class="content">
    <div class="title">Paiement échoué</div>
    <p class="message">
      Désolé, votre paiement a échoué. Veuillez vérifier les informations de
      votre carte de crédit et réessayer.
    </p>
    <button class="btn" @click="goToPanier">Réessayer le paiement</button>
  </div>
</template>

<style scoped lang="scss">
.content {
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
  margin-top: 100px;
}
.title {
  font-size: 36px;
  font-weight: bold;
  color: #333;
  margin-bottom: 30px;
}
.message {
  font-size: 18px;
  color: #555;
  margin-bottom: 50px;
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
