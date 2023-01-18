<template>
  <section>
    <form @submit.prevent="createUser">
      <div>
        <label for="email">Email :</label>
        <input type="email" id="email" v-model="userData.email" />
      </div>
      <div>
        <label for="password">Password: </label>
        <input type="password" id="password" v-model="userData.password" />
      </div>

      <button>Create User</button>
    </form>
  </section>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      userData: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    createUser() {
      axios
        .post("https://api-challenge.moon-factory.fr/user/new", this.userData)
        .then((response) => console.log(response));
    },
  },
};
</script>

<style>
html,
body {
  margin: 0;
  padding: 0;
}
section {
  height: 100vh;
  display: grid;
  justify-items: center;
  padding-top: 40px;
}
div {
  margin: 24px auto;
}
label {
  font-weight: bolder;
  display: block;
  margin-bottom: 4px;
}
</style>
