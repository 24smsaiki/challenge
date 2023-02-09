<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import { createToast } from "mosha-vue-toastify";
import Header from "../Header.vue";
import Sidebar from "./Sidebar.vue";

const settingsForm = ref({
  username: "",
  firstname: "",
  lastname: "",
  email: "",
  password: "",
  confirmPassword: "",
});

const isFormValid = computed(() => {
  if (
    settingsForm.value.username === "" ||
    settingsForm.value.firstname === "" ||
    settingsForm.value.lastname === "" ||
    settingsForm.value.email === "" ||
    settingsForm.value.password === "" ||
    settingsForm.value.confirmPassword === "" ||
    settingsForm.value.password !== settingsForm.value.confirmPassword
  ) {
    return false;
  } else {
    return true;
  }
});

const setValidFormClass = computed(() => {
  if (isFormValid.value === true) {
    return "";
  } else {
    return {
      cursor: "not-allowed",
      backgroundColor: "#e0e0e0",
    };
  }
});

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

// TODO WAIT FOR API TO FINISH
const updateUser = () => {
  // console.log(">>>", settingsForm.value);
  // axios
  //   .put(
  //     "https://localhost/users",
  //     {
  //       firstname: settingsForm.value.firstname,
  //       lastname: settingsForm.value.lastname,
  //       email: settingsForm.value.email,
  //     },
  //     {
  //       headers: {
  //         Authorization:
  //           "Bearer " +
  //           `${localStorage.getItem("app-token").split('"').join("")}`,
  //       },
  //     }
  //   )
  //   .then((response) => response)
  //   .then((res) => {
  //     if (res.status === 200) {
  //       setToast("Vos informations ont été mises à jour", "success");
  //     }
  //   })
  //   .catch(() =>
  //     setToast("Une erreur est survenue lors de la mise à jour", "danger")
  //   );
};

const getUserData = () => {
  axios
    .get("https://localhost/users", {
      headers: {
        Authorization:
          "Bearer " +
          `${localStorage.getItem("app-token").split('"').join("")}`,
      },
    })
    .then((response) => response)
    .then((res) => {
      const user = res?.data["hydra:member"][0];
      settingsForm.value.username = `${user.firstname} ${user.lastname}`;
      settingsForm.value.firstname = user.firstname;
      settingsForm.value.lastname = user.lastname;
      settingsForm.value.email = user.email;
      settingsForm.value.password = "fakePassword";
      settingsForm.value.confirmPassword = "fakePassword";
    })
    .catch(() =>
      setToast("Une erreur est survenue lors du chargement", "danger")
    );
};

getUserData();
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <section id="settings">
    <Sidebar />
    <div class="content">
      <div class="settings">
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="username"
            >Nom d'utilisateur</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="username"
            type="text"
            placeholder="Entrer le nom d'utilisateur"
            v-model="settingsForm.username"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="firstname">Prénom</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="firstname"
            type="text"
            placeholder="Entrer le prénom"
            v-model="settingsForm.firstname"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="lastname">Nom</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="lastname"
            type="text"
            placeholder="Entrer le nom"
            v-model="settingsForm.lastname"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="email">Adresse email</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="email"
            type="email"
            placeholder="Entrer l'adresse email"
            v-model="settingsForm.email"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="password"
            >Mot de passe</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="password"
            type="password"
            placeholder="Entrer le mot de passe"
            v-model="settingsForm.password"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="confirmPassword"
            >Mot de passe confirmation</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="confirmPassword"
            type="password"
            placeholder="Confirmer le mot de passe"
            v-model="settingsForm.confirmPassword"
          />
        </div>
        <button
          class="btn mt-2"
          @click="updateUser"
          :disabled="!isFormValid"
          :style="setValidFormClass"
        >
          Mettre à jour
        </button>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
#settings {
  .settings {
    font-size: 20px;
    height: 100%;
    overflow: auto;
  }

  .is-invalid {
    cursor: not-allowed;
  }

  input {
    border-radius: 5px;
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
}
</style>
