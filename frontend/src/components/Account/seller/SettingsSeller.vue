<script setup>
import { ref, computed } from "vue";
import { createToast } from "mosha-vue-toastify";
import Header from "../../Header.vue";
import Sidebar from "./SidebarSeller.vue";
import SettingsLogic from "../../../logics/SettingsLogic";

const settingsForm = ref({
  username: "",
  firstname: "",
  lastname: "",
  password: "",
  confirmPassword: "",
  shopName: "",
  shopDescription: "",
  shopEmail: "",
  shopPhone: "",
});

const errors = ref({
  username: "",
  firstname: "",
  lastname: "",
  email: "",
  password: "",
  confirmPassword: "",
  shopName: "",
  shopDescription: "",
  shopEmail: "",
  shopPhone: "",
});

let sellerId = null;

const isFormValid = computed(() => {
  if (
    settingsForm.value.username !== "" &&
    settingsForm.value.firstname !== "" &&
    settingsForm.value.lastname !== "" &&
    settingsForm.value.password !== "" &&
    settingsForm.value.confirmPassword !== "" &&
    settingsForm.value.shopName !== "" &&
    settingsForm.value.shopEmail !== "" &&
    settingsForm.value.shopPhone !== "" &&
    errors.value.username === "" &&
    errors.value.firstname === "" &&
    errors.value.lastname === "" &&
    errors.value.password === "" &&
    errors.value.confirmPassword === "" &&
    errors.value.shopName === "" &&
    errors.value.shopEmail === "" &&
    errors.value.shopPhone === ""
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

const isShopName = () => {
  const shopName = settingsForm.value.shopName;

  if (shopName.length < 3) {
    errors.value.shopName =
      "Le nom de la boutique doit contenir au moins 3 caractères";
  } else {
    errors.value.shopName = "";
  }
};

const isShopPhone = () => {
  const phone = settingsForm.value.shopPhone;
  const regex = new RegExp("^[0-9]{10}$");

  if (!regex.test(phone)) {
    errors.value.shopPhone = "Le numéro de téléphone n'est pas valide";
  } else {
    errors.value.shopPhone = "";
  }
};

function setToast(message, type) {
  createToast(message, {
    position: "top-right",
    timeout: 5000,
    close: true,
    type: type,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
  });
}

const updateSeller = () => {
  if (isFormValid.value === true) {
    const userInfo = {
      firstname: settingsForm.value.firstname,
      lastname: settingsForm.value.lastname,
      password: settingsForm.value.password,
    };
    const shopInfo = {
      shopLabel: settingsForm.value.shopName,
      shopDescription: settingsForm.value.shopDescription,
      shopEmailContact: settingsForm.value.shopEmail,
      shopPhoneContact: settingsForm.value.shopPhone,
    };
    Promise.all([
      SettingsLogic.updateUserInformation(userInfo),
      SettingsLogic.updateShopInformation(sellerId, shopInfo),
    ])
      .then((res) => {
        if (res[0].status === 200 && res[1].status === 200) {
          setToast("Vos informations ont été mises à jour", "success");
        }
      })
      .catch(() => {
        setToast("Une erreur est survenue lors de la mise à jour", "danger");
      });
  }
};

const getSellerInformation = () => {
  Promise.all([
    SettingsLogic.getUserInformation(),
    SettingsLogic.getShopInformation(),
  ])
    .then((res) => {
      if (res[0].status === 200 && res[1].status === 200) {
        if (res[0]?.data[0] && res[1]?.data[0]) {
          // user information
          settingsForm.value.username = `${res[0].data[0].firstname} ${res[0].data[0].lastname}`;
          settingsForm.value.firstname = res[0].data[0].firstname;
          settingsForm.value.lastname = res[0].data[0].lastname;

          // shop information
          sellerId = res[1].data[0].id;
          settingsForm.value.shopName = res[1].data[0].shopLabel;
          settingsForm.value.shopDescription = res[1].data[0].shopDescription;
          settingsForm.value.shopEmail = res[1].data[0].shopEmailContact;
          settingsForm.value.shopPhone = res[1].data[0].shopPhoneContact;
        }
      }
    })
    .catch(() => {
      setToast(
        "Une erreur est survenue lors du chargement des informations",
        "danger"
      );
    });
};

getSellerInformation();
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
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="lastname"
            >Nom de l'utilisateur</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="lastname"
            type="text"
            placeholder="Nom de l'utilisateur"
            v-model="settingsForm.lastname"
            @input="isLastName"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.lastname">
          {{ errors.lastname }}
        </p>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="firstname"
            >Prénom de l'utilisateur</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="firstname"
            type="text"
            placeholder="Prénom de l'utilisateur"
            v-model="settingsForm.firstname"
            @input="isFirstName"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.firstname">
          {{ errors.firstname }}
        </p>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="shopName"
            >Nom de la boutique</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopName"
            type="text"
            placeholder="Nom de la boutique"
            v-model="settingsForm.shopName"
            @input="isShopName"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.shopName">
          {{ errors.shopName }}
        </p>
        <div class="ml-2 mb-5 mr-2">
          <label class="block mb-2" for="shopDescription"
            >Description de la boutique</label
          >
          <textarea
            placeholder="Description de la boutique"
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopDescription"
            type="text"
            v-model="shopDescription"
          ></textarea>
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="shopEmail"
            >Email de la boutique</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopEmail"
            type="text"
            disabled
            readonly
            placeholder="Email de la boutique"
            :value="settingsForm.shopEmail"
          />
        </div>
        <div class="ml-2 mb-5 mr-2">
          <label class="block font-bold mb-2" for="shopPhone"
            >Téléphone de la boutique</label
          >
          <input
            class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
            id="shopPhone"
            type="text"
            placeholder="Téléphone de la boutique"
            v-model="settingsForm.shopPhone"
            @input="isShopPhone"
          />
        </div>
        <p class="messageErrors mb-3 ml-0" v-if="errors?.shopPhone">
          {{ errors.shopPhone }}
        </p>
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
          @click="updateSeller"
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
