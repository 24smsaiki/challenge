<script setup>
import { reactive, ref } from "vue";
import Header from "../components/Header.vue";
import AuthLogic from "../logics/AuthLogic";
import { createToast } from "mosha-vue-toastify";
import router from "../router/Router";

const loading = ref(false);

const seller = reactive({
  shopLabel: "",
  shopDescription: "",
  shopEmailContact: "",
  shopPhoneContact: "",
  password: "",
  confirmPassword: "",
  firstname: "",
  lastname: "",
});

const errors = reactive({
  shopLabel: "",
  shopDescription: "",
  shopEmailContact: "",
  shopPhoneContact: "",
  password: "",
  confirmPassword: "",
  firstname: "",
  lastname: "",
});

const isFormValid = () => {
  if (
    seller.shopLabel !== "" &&
    seller.shopDescription !== "" &&
    seller.shopEmailContact !== "" &&
    seller.shopPhoneContact !== "" &&
    seller.password !== "" &&
    seller.confirmPassword !== "" &&
    seller.firstname !== "" &&
    seller.lastname !== "" &&
    errors.shopLabel === "" &&
    errors.shopDescription === "" &&
    errors.shopEmailContact === "" &&
    errors.shopPhoneContact === "" &&
    errors.password === "" &&
    errors.confirmPassword === "" &&
    errors.firstname === "" &&
    errors.lastname === ""
  ) {
    return true;
  } else {
    return false;
  }
};

const setValidFormClass = () => {
  if (isFormValid() === true) {
    return "";
  } else {
    return {
      cursor: "not-allowed",
      backgroundColor: "#e0e0e0",
    };
  }
};

const isShopLabel = () => {
  const shopLabel = seller.shopLabel;

  if (shopLabel.length < 3) {
    errors.shopLabel =
      "Le nom de la boutique doit contenir au moins 3 caractères.";
  } else {
    errors.shopLabel = "";
  }
};

const isShopDescription = () => {
  const shopDescription = seller.shopDescription;

  if (shopDescription.length < 10) {
    errors.shopDescription =
      "La description de l'activité doit contenir au moins 10 caractères.";
  } else {
    errors.shopDescription = "";
  }
};

const isShopEmailContact = () => {
  const shopEmailContact = seller.shopEmailContact;
  const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

  if (!regex.test(shopEmailContact)) {
    errors.shopEmailContact = "Veuillez entrer un email valide.";
  } else {
    errors.shopEmailContact = "";
  }
};

const isShopPhoneContact = () => {
  const shopPhoneContact = seller.shopPhoneContact;
  const regex = /^(\+33|0033|0)[1-9](\d{2}){4}$/;

  if (!regex.test(shopPhoneContact)) {
    errors.shopPhoneContact = "Veuillez entrer un numéro de téléphone valide.";
  } else {
    errors.shopPhoneContact = "";
  }
};

const isPassword = () => {
  const password = seller.password;

  if (password.length < 8) {
    errors.password = "Le mot de passe doit contenir au moins 8 caractères.";
  } else {
    errors.password = "";
  }
};

const isConfirmPassword = () => {
  const password = seller.password;
  const confirmPassword = seller.confirmPassword;

  if (password !== confirmPassword) {
    errors.confirmPassword = "Les mots de passe ne correspondent pas.";
  } else {
    errors.confirmPassword = "";
  }
};

const redirectToHome = () => {
  router.push({ name: "Home" });
};

const onSubmit = () => {
  if (isFormValid() === true) {
    AuthLogic.registerSeller(seller)
      .then(() => {
        loading.value = false;

        redirectToHome();
        createToast("Votre demande va être examinée. ", {
          type: "success",
          position: "top-right",
          timeout: 3000,
        });
      })
      .catch((error) => {
        loading.value = false;

        if (error.response.status ? error.response.status === 500 : false) {
          createToast(
            "Une erreur est survenue. Veuillez réessayer ultérieurement.",
            {
              type: "error",
              position: "top-right",
              timeout: 3000,
            }
          );
        }
      })
      .finally(() => {
        loading.value = false;
      });
  }
};
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)" />

  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,700"
    rel="stylesheet"
    type="text/css"
  />

  <div class="container">
    <div class="frame">
      <template v-if="!loading">
        <div class="nav">
          <ul class="links">
            <li class="signin-active btn">
              <a class="btn">Devenir vendeur</a>
            </li>
          </ul>
        </div>
        <div>
          <form class="form-signin">
            <label>Nom de la boutique</label>
            <input
              class="form-styling"
              type="text"
              name="username"
              placeholder="Nom de la boutique"
              v-model="seller.shopLabel"
              @input="isShopLabel"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.shopLabel">
              {{ errors.shopLabel }}
            </p>
            <label for="username">Description de l'activité</label>
            <textarea
              class="form-styling-textarea"
              rows="4"
              cols="50"
              name="username"
              v-model="seller.shopDescription"
              @input="isShopDescription"
            ></textarea>
            <p class="messageErrors mb-3 ml-0" v-if="errors?.shopDescription">
              {{ errors.shopDescription }}
            </p>
            <div class="parent">
              <div>
                <label for="username">Addresse email</label>
                <input
                  class="form-styling"
                  type="text"
                  name="username"
                  placeholder="Adresse email"
                  v-model="seller.shopEmailContact"
                  @input="isShopEmailContact"
                />
                <p
                  class="messageErrors mb-3 ml-0"
                  v-if="errors?.shopEmailContact"
                >
                  {{ errors.shopEmailContact }}
                </p>
              </div>
              <div>
                <label for="name">Téléphone</label>
                <input
                  type="text"
                  name="lastname"
                  id="lastname"
                  placeholder="Téléphone"
                  ref="lastname"
                  class="form-styling"
                  v-model="seller.shopPhoneContact"
                  @input="isShopPhoneContact"
                />
                <p
                  class="messageErrors mb-3 ml-0"
                  v-if="errors?.shopPhoneContact"
                >
                  {{ errors.shopPhoneContact }}
                </p>
              </div>
            </div>
            <div class="parent">
              <div>
                <label for="name">Nom</label>
                <input
                  type="text"
                  name="lastname"
                  id="lastname"
                  ref="lastname"
                  placeholder="Nom"
                  class="form-styling"
                  v-model="seller.lastname"
                  @input="isLastname"
                />
                <p class="messageErrors mb-3 ml-0" v-if="errors?.lastname">
                  {{ errors.lastname }}
                </p>
              </div>
              <div>
                <label for="name">Prénom</label>
                <input
                  type="text"
                  name="firstname"
                  id="firstname"
                  ref="firstname"
                  spellcheck="false"
                  placeholder="Prénom"
                  class="form-styling"
                  v-model="seller.firstname"
                  @input="isFirstname"
                />
                <p class="messageErrors mb-3 ml-0" v-if="errors?.firstname">
                  {{ errors.firstname }}
                </p>
              </div>
            </div>
            <div class="parent">
              <div>
                <label for="password">Mot de passe</label>
                <input
                  class="form-styling"
                  type="password"
                  name="password"
                  placeholder="Mot de passe"
                  v-model="seller.password"
                  @input="isPassword"
                />
                <p class="messageErrors mb-3 ml-0" v-if="errors?.password">
                  {{ errors.password }}
                </p>
              </div>
              <div>
                <label for="password">Confirm password </label>
                <input
                  type="password"
                  name="confirmPassword"
                  placeholder="Confirmer le mot de passe"
                  class="form-styling"
                  v-model="seller.confirmPassword"
                  @input="isConfirmPassword"
                />
                <p
                  class="messageErrors mb-3 ml-0"
                  v-if="errors?.confirmPassword"
                >
                  {{ errors.confirmPassword }}
                </p>
              </div>
            </div>
            <div class="btn-animate">
              <button
                @click.prevent="onSubmit"
                class="btn-signin"
                :disabled="!isFormValid"
                :style="setValidFormClass"
              >
                Soumettre
              </button>
            </div>
          </form>
          <div class="success">
            <svg
              width="270"
              height="270"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              x="0px"
              y="0px"
              viewBox="0 0 60 60"
              id="check"
              ng-class="checked ? 'checked' : ''"
            >
              <path
                fill="#ffffff"
                d="M40.61,23.03L26.67,36.97L13.495,23.788c-1.146-1.147-1.359-2.936-0.504-4.314
                  c3.894-6.28,11.169-10.243,19.283-9.348c9.258,1.021,16.694,8.542,17.622,17.81c1.232,12.295-8.683,22.607-20.849,22.042
                  c-9.9-0.46-18.128-8.344-18.972-18.218c-0.292-3.416,0.276-6.673,1.51-9.578"
              />
            </svg>
            <div class="successtext">
              <p>
                Merci pour l'enregistrement! Vérifiez votre e-mail pour
                confirmation
              </p>
            </div>
          </div>
        </div>
      </template>
      <img
        v-else
        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANwAAADcCAMAAAAshD+zAAAAFVBMVEUAAACpqalNTU16enoRERHa2torKytuXfZEAAAEFklEQVR4nO2c4bKjIAxGRZD3f+RVRIREd2mLJrDfmfvL3nE4JoaAttMEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHSFW5EewzM4Pwf8gH5RLehJj6UxLnMbLniF22CxczOh69CVVdF5KufLf+6oiDq/k0bMApeFrq8ieoYpjfcvcus/20AXqZqn4GHHsjLlpY9qQU99mbms+bdyuZt+u3QHFXZ3aVm6rXa6M5Np+MujUY64Was6dBc1f7PgcvEwlVMduhu5m0mcZqXyu47Lxbyk7ddIcjR0sYhSt+7kHP/knP46lzu7lPSZO7uTrgoKn66zltGFnjPrkS+qpcSYq2Gh+2uesUlcc1ZOH65Kaeh0Z+Wn+wmlnU43ly031xur2q20O5dBxWJQlr1QeKpXN0AX77t0JdIBDXrHsjvTc5tu9dZBuBbpQmShlC8vmdvKtyfJNiTym1DYrnT7OZNo+ZS1I3K/2tFuU7R+Urcf7XjLIhm6xnIXy4RWI/1mNI/LCeZlWzmeldZC7hkapyWXk0zL5wvK0HKtRvoFTO63C81vOtHmeej2q03jnJ1Ok1tazYW4NUiifFtF3G26eJD629nS00gNblO5zdDgbL5qhwIA0BS2+S4wgra15Dzx0YnNQnouo/WpZ2siMr2zc4/ZrWEzRtTOPWbnZpMjsDRwz8l5a0q710NH5Rp2KMTNmLdDx9zaydHAvR86yH135pnLvbxA4HKt7Eit1CHX7NQjp6UCuTengvdn8cfcNEziQ7dfxK7pmYvQCW2pP+UWNviE3U67B84svVh9lu0VRtlthmcZVgx0iKt4U7NTjhWPmgchDcnmb+VvPH9O2VaOZUcXBCPZsUW4ioerjeDL1IFC56mbxFLuKS62hoaR41vNA910Q8sNnZZjF5ShpwI+iY8TOFZSlJaTz3aNsq+7WOVu8XtUla9vufC7GueXsKxuN2uWQNXozhoS9ye390k3M5WLVW+XhPnn+Da3ZVPLroXet/a8WZZ6O7+bBeoiLYmzy1JvVxbHRXvlnxeCLT4mNZS1W6rnbBq4NXSnzl4Ws7e8eaOsOnSzoXLLEYyt+wi2Jj22YYGrqECCsKxMeZkX0aNwXMhpzstbubKIRrtB5Oi9uN9b/cuF4dJ70RxHeyqXnhWUUCIcP+ymcgqP1VJzQZnYVBCy8sZ56mxtSjX24XqWrLsc3VbQHTh2181XB8MHsaQseXOp3I2I2ItjuXVZMHUnZeCsjGm0d2k57XZL+NOekzthjVaM9q6ghM/2J6kq16aX0N9D4f103iHv/y0wzEawItpLmGq4br9GobQbyy0s584iOphbeA9v3+iyPRePW8JPCXZdFwEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD8j/wBBVgr9+m+9ycAAAAASUVORK5CYII="
      />
    </div>
  </div>
</template>

<style lang="scss" scoped>
.messageErrors {
  color: red;
  font-size: 14px;
}

.parent {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

body {
  background: linear-gradient(
      rgba(246, 247, 249, 0.8),
      rgba(246, 247, 249, 0.8)
    ),
    url(https://dl.dropboxusercontent.com/u/22006283/preview/codepen/sky-clouds-cloudy-mountain.jpg)
      no-repeat center center fixed;
  background-size: cover;
}

.container {
  width: 100%;
  padding-top: 60px;
  padding-bottom: 100px;
}

.frame {
  width: 430px;
  background: black;
  background-size: cover;
  margin-left: auto;
  margin-right: auto;
  border-top: solid 1px rgba(255, 255, 255, 0.5);
  border-radius: 5px;
  box-shadow: 0px 2px 7px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  transition: all 0.5s ease;
}

.nav {
  width: 100%;
  height: 100px;
  padding-top: 40px;
  opacity: 1;
  transition: all 0.5s ease;
}

li {
  padding-left: 10px;
  font-size: 18px;
  display: inline;
  text-align: left;
  text-transform: uppercase;
  padding-right: 10px;
  color: #ffffff;
}

.signin-active a {
  padding-bottom: 10px;
  color: #ffffff;
  text-decoration: none;
  border-bottom: solid 2px #d87d4a;
  transition: all 0.25s ease;
  cursor: pointer;
}

.form-signin {
  width: 430px;
  height: 375px;
  font-size: 16px;
  font-weight: 300;
  padding-left: 37px;
  padding-right: 37px;
  transition: opacity 0.5s ease, transform 0.5s ease;
}

.success {
  width: 80%;
  height: 150px;
  text-align: center;
  position: relative;
  top: -890px;
  left: 450px;
  opacity: 0;
  transition: all 0.8s 0.4s ease;
}

.successtext {
  color: #ffffff;
  font-size: 16px;
  font-weight: 300;
  margin-top: -35px;
  padding-left: 37px;
  padding-right: 37px;
}

#check path {
  stroke: #ffffff;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-width: 0.85px;
  stroke-dasharray: 60px 300px;
  stroke-dashoffset: -166px;
  fill: rgba(255, 255, 255, 0);
  transition: stroke-dashoffset 2s ease 0.5s, fill 1.5s ease 1s;
}

#check.checked path {
  stroke-dashoffset: 33px;
  fill: rgba(255, 255, 255, 0.03);
}

.form-signin input {
  color: #ffffff;
  font-size: 13px;
}

.form-signin textarea {
  color: #ffffff;
  font-size: 13px;
}

.form-styling {
  width: 100%;
  height: 35px;
  padding-left: 15px;
  border: none;
  border-radius: 20px;
  margin-bottom: 20px;
  background: rgba(255, 255, 255, 0.2);
}

.form-styling-textarea {
  width: 100%;
  padding-left: 15px;
  border: none;
  border-radius: 20px;
  margin-bottom: 20px;
  background: rgba(255, 255, 255, 0.2);
}

label {
  font-weight: 400;
  text-transform: uppercase;
  font-size: 13px;
  padding-left: 15px;
  padding-bottom: 10px;
  color: rgba(255, 255, 255, 0.7);
  display: block;
}

:focus {
  outline: none;
}

.form-signin input:focus,
textarea:focus,
input:focus,
textarea:focus {
  background: rgba(255, 255, 255, 0.3);
  border: none;
  padding-right: 40px;
  transition: background 0.5s ease;
}

[type="checkbox"]:not(:checked),
[type="checkbox"]:checked {
  position: absolute;
  display: none;
}

[type="checkbox"]:not(:checked) + label,
[type="checkbox"]:checked + label {
  position: relative;
  padding-left: 85px;
  padding-top: 2px;
  cursor: pointer;
  margin-top: 8px;
}

[type="checkbox"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before,
[type="checkbox"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after {
  content: "";
  position: absolute;
}

[type="checkbox"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before {
  width: 65px;
  height: 30px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 15px;
  left: 0;
  top: -3px;
  transition: all 0.2s ease;
}

[type="checkbox"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after {
  width: 10px;
  height: 10px;
  background: rgba(255, 255, 255, 0.7);
  border-radius: 50%;
  top: 7px;
  left: 10px;
  transition: all 0.2s ease;
}

[type="checkbox"]:checked + label:before {
  background: #0f4fe6;
}

[type="checkbox"]:checked + label:after {
  background: #ffffff;
  top: 7px;
  left: 45px;
}

[type="checkbox"]:checked + label .ui,
[type="checkbox"]:not(:checked) + label .ui:before,
[type="checkbox"]:checked + label .ui:after {
  position: absolute;
  left: 6px;
  width: 65px;
  border-radius: 15px;
  font-size: 14px;
  font-weight: bold;
  line-height: 22px;
  transition: all 0.2s ease;
}

[type="checkbox"]:not(:checked) + label .ui:before {
  content: "no";
  left: 32px;
  color: rgba(255, 255, 255, 0.7);
}

[type="checkbox"]:checked + label .ui:after {
  content: "yes";
  color: #ffffff;
}

[type="checkbox"]:focus + label:before {
  box-sizing: border-box;
  margin-top: -1px;
}

.btn-signin {
  float: left;
  padding-top: 8px;
  width: 100%;
  height: 35px;
  border: none;
  border-radius: 20px;
  margin-top: -8px;
}

.btn-animate {
  float: left;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 13px;
  text-align: center;
  padding-top: 8px;
  width: 100%;
  height: 35px;
  border: none;
  border-radius: 20px;
  background-color: white;
  left: 0px;
  top: 0px;
  transition: all 0.5s ease, top 0.5s ease 0.5s, height 0.5s ease 0.5s,
    background-color 0.5s ease 0.75s;
}

a.btn-signin:hover {
  cursor: pointer;
  background-color: #0f4fe6;
  transition: background-color 0.5s;
}

h1 {
  color: #ffffff;
  font-size: 35px;
  font-weight: 300;
  text-align: center;
}
</style>
