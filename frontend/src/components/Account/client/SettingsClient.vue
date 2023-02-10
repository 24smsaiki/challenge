<script setup>
import { ref, computed } from "vue";
import { createToast } from "mosha-vue-toastify";
import Header from "../../Header.vue";
import Sidebar from "./SidebarClient.vue";
import SettingsLogic from "../../../logics/Account/client/SettingsLogic";

const settingsForm = ref({
  username: "",
  firstname: "",
  lastname: "",
  email: "",
  password: "",
  confirmPassword: "",
});
const errors = ref({
  username: "",
  firstname: "",
  lastname: "",
  email: "",
  password: "",
  confirmPassword: "",
});

const isFormValid = computed(() => {
  if (
    settingsForm.value.username !== "" &&
    settingsForm.value.firstname !== "" &&
    settingsForm.value.lastname !== "" &&
    settingsForm.value.password !== "" &&
    settingsForm.value.confirmPassword !== "" &&
    errors.value.username === "" &&
    errors.value.firstname === "" &&
    errors.value.lastname === "" &&
    errors.value.password === "" &&
    errors.value.confirmPassword === ""
  ) {
    return true;
  } else {
    return false;
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

const isUserName = () => {
  const username = settingsForm.value.username;

  if (username.length < 3) {
    errors.value.username =
      "Le nom d'utilisateur doit contenir au moins 3 caractères";
  } else {
    errors.value.username = "";
  }
};

const isFirstName = () => {
  const firstname = settingsForm.value.firstname;

  if (firstname.length < 3) {
    errors.value.firstname = "Le prénom doit contenir au moins 3 caractères";
  } else {
    errors.value.firstname = "";
  }
};

const isLastName = () => {
  const lastname = settingsForm.value.lastname;

  if (lastname.length < 3) {
    errors.value.lastname = "Le nom doit contenir au moins 3 caractères";
  } else {
    errors.value.lastname = "";
  }
};

const isPassword = () => {
  const password = settingsForm.value.password;
  const confirmPassword = settingsForm.value.confirmPassword;

  if (password.length < 8) {
    errors.value.password =
      "Le mot de passe doit contenir au moins 8 caractères";
  } else if (password !== confirmPassword) {
    errors.value.password = "Les mots de passe ne correspondent pas";
  } else {
    errors.value.password = "";
  }

  if (password === confirmPassword) {
    errors.value.password = "";
    errors.value.confirmPassword = "";
  }
};

const isConfirmPassword = () => {
  const confirmPassword = settingsForm.value.confirmPassword;
  const password = settingsForm.value.password;

  if (confirmPassword.length < 8) {
    errors.value.confirmPassword =
      "Le mot de passe doit contenir au moins 8 caractères";
  } else if (confirmPassword !== password) {
    errors.value.confirmPassword = "Les mots de passe ne correspondent pas";
  } else {
    errors.value.confirmPassword = "";
  }

  if (password === confirmPassword) {
    errors.value.password = "";
    errors.value.confirmPassword = "";
  }
};

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

const updateUser = () => {
  const data = {
    firstname: settingsForm.value.firstname,
    lastname: settingsForm.value.lastname,
    password: settingsForm.value.password,
  };

  SettingsLogic.updateUserInformation(data)
    .then((res) => {
      if (res.status === 200) {
        setToast("Vos informations ont été mises à jour", "success");
      }
    })
    .catch(() => {
      setToast("Une erreur est survenue lors de la mise à jour", "danger");
    });
};

const getUserInformation = () => {
  SettingsLogic.getUserInformation()
    .then((res) => {
      if (res.status === 200) {
        const user = res.data[0];
        settingsForm.value.username = `${user.firstname} ${user.lastname}`;
        settingsForm.value.firstname = user.firstname;
        settingsForm.value.lastname = user.lastname;
        settingsForm.value.email = user.email;
        settingsForm.value.password = "";
        settingsForm.value.confirmPassword = "";
      }
    })
    .catch(() =>
      setToast("Une erreur est survenue lors du chargement", "danger")
    );
};

getUserInformation();
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
            placeholder="Nom d'utilisateur"
            :value="settingsForm.username"
            disabled
            readonly
            @input="isUserName"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.username">
          {{ errors.username }}
        </p>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="firstname">Prénom</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="firstname"
            type="text"
            placeholder="Prénom"
            v-model="settingsForm.firstname"
            @input="isFirstName"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.firstname">
          {{ errors.firstname }}
        </p>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="lastname">Nom</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="lastname"
            type="text"
            placeholder="Nom"
            v-model="settingsForm.lastname"
            @input="isLastName"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.lastname">
          {{ errors.lastname }}
        </p>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="email">Adresse email</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="email"
            type="email"
            placeholder="Adresse email"
            :value="settingsForm.email"
            disabled
            readonly
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
            placeholder="Mot de passe"
            v-model="settingsForm.password"
            @input="isPassword"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.password">
          {{ errors.password }}
        </p>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="confirmPassword"
            >Mot de passe confirmation</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="confirmPassword"
            type="password"
            placeholder="Mot de passe de confirmation"
            v-model="settingsForm.confirmPassword"
            @input="isConfirmPassword"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.confirmPassword">
          {{ errors.confirmPassword }}
        </p>
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

  .messageErrors {
    color: red;
    font-size: 14px;
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
