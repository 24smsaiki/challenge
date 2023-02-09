<script setup>
import Header from "../Header.vue";
import Sidebar from "./Sidebar.vue";
import { ref, computed } from "vue";
import axios from "axios";

const dataUsingToTest = {
  "@context": "/contexts/Address",
  "@id": "/addresses",
  "@type": "hydra:Collection",
  "hydra:member": [
    {
      "@id": "/addresses/1",
      "@type": "Address",
      id: 1,
      firstname: "John",
      lastname: "Doe",
      phone: "0606060606",
      addressField: "1 rue de la paix",
      addressFieldInformation: "Appartement 1",
      zipCode: "75000",
      city: "Paris",
      country: "France",
      customer: "/users/1",
      orders: ["/orders/1"],
    },
    {
      "@id": "/addresses/2",
      "@type": "Address",
      id: 2,
      firstname: "Jane",
      lastname: "Doe",
      phone: "0606060606",
      addressField: "2 rue de la paix",
      addressFieldInformation: "Appartement 2",
      zipCode: "75000",
      city: "Paris",
      country: "France",
      customer: "/users/1",
      orders: ["/orders/2"],
    },
  ],
  "hydra:totalItems": 2,
};

const addresses = ref([]);
const newAddress = ref({
  firstname: "",
  lastname: "",
  addressField: "",
  zipCode: "",
  city: "",
  country: "",
  phone: "",
  addressFieldInformation: "",
});

const addingField = ref(false);
const editingField = ref(false);
const addressIndex = ref(0);

const addNewFieldClick = () => (addingField.value = !addingField.value);

const resetFormFields = () => {
  newAddress.value.firstname = "";
  newAddress.value.lastname = "";
  newAddress.value.addressField = "";
  newAddress.value.zipCode = "";
  newAddress.value.city = "";
  newAddress.value.country = "";
  newAddress.value.phone = "";
  newAddress.value.addressFieldInformation = "";
};

const addAddress = () => {
  // addresses.value.push(Object.assign({}, newAddress.value));
  // TODO POST WITH AXIOS

  // axios
  //   .post("http://localhost/addresses", newAddress.value)
  //   .then((response) => {
  //     console.log(response);
  //   })
  //   .catch((error) => {
  //     console.log(error);
  //   });

  resetFormFields();
  addingField.value = false;
};

const editAddress = (index) => {
  editingField.value = !editingField.value;
  addressIndex.value = index;
  addingField.value = false;

  if (editingField.value) {
    setFormFields();
  } else {
    resetFormFields();
  }
};

const cancelEdition = () => {
  editingField.value = false;
  resetFormFields();
};

const cancelAddition = () => {
  addingField.value = false;
  resetFormFields();
};

const setFormFields = () => {
  newAddress.value.firstname = addresses.value[addressIndex.value].firstname;
  newAddress.value.lastname = addresses.value[addressIndex.value].lastname;
  newAddress.value.addressField =
    addresses.value[addressIndex.value].addressField;
  newAddress.value.zipCode = addresses.value[addressIndex.value].zipCode;
  newAddress.value.city = addresses.value[addressIndex.value].city;
  newAddress.value.country = addresses.value[addressIndex.value].country;
  newAddress.value.phone = addresses.value[addressIndex.value].phone;
  newAddress.value.addressFieldInformation =
    addresses.value[addressIndex.value].addressFieldInformation;
};

const updateAddress = () => {
  // addresses.value[addressIndex.value] = Object.assign({}, newAddress.value);
  // TODO UPDATE WITH AXIOS
  resetFormFields();
  editingField.value = false;
};

const deleteAddress = (index) => addresses.value.splice(index, 1);

const isFormValid = computed(() => {
  if (
    newAddress.value.firstname === "" ||
    newAddress.value.lastname === "" ||
    newAddress.value.addressField === "" ||
    newAddress.value.zipCode === "" ||
    newAddress.value.city === "" ||
    newAddress.value.country === "" ||
    newAddress.value.phone === "" ||
    newAddress.value.addressFieldInformation === ""
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

const setAddresses = () => {
  axios
    .get("https://localhost/addresses", {
      headers: {
        Authorization:
          "Bearer " +
          `${localStorage.getItem("app-token").split('"').join("")}`,
      },
    })
    .then((response) => response)
    .then((res) => {
      // addresses.value = res?.data["hydra:member"];
      addresses.value = dataUsingToTest["hydra:member"];
    })
    .catch((error) => {
      console.log(error);
    });
};

setAddresses();
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <section id="addresses">
    <Sidebar />
    <div class="content">
      <div class="addresses">
        <legend>
          <h1 class="mb-5">Mes adresses</h1>

          <!-- Data -->
          <div v-for="(address, index) in addresses" :key="index">
            <div v-if="!editingField && !addingField" class="address">
              <div class="personalInformation">
                <div class="form-group mb-3 d-flex">
                  <label for="country" class="mr-3 font-bold">Prénom :</label>
                  <p readonly disabled>
                    {{ address.firstname }}
                  </p>
                </div>
                <div class="form-group mb-3 d-flex">
                  <label for="country" class="mr-3 font-bold">Nom :</label>
                  <p readonly disabled>
                    {{ address.lastname }}
                  </p>
                </div>
                <div class="form-group mb-3 d-flex">
                  <label for="country" class="mr-3 font-bold">Adresse :</label>
                  <p readonly disabled>
                    {{ address.addressField }}
                  </p>
                </div>
                <div class="form-group mb-3 d-flex">
                  <label for="country" class="mr-3 font-bold">Ville :</label>
                  <p readonly disabled>
                    {{ address.city }}
                  </p>
                </div>
                <div class="form-group mb-3 d-flex">
                  <label for="country" class="mr-3 font-bold"
                    >Code postal :</label
                  >
                  <p readonly disabled>
                    {{ address.zipCode }}
                  </p>
                </div>
                <div class="form-group mb-3 d-flex">
                  <label for="country" class="mr-3 font-bold">Pays :</label>
                  <p readonly disabled>
                    {{ address.country }}
                  </p>
                </div>
                <div class="form-group mb-3 d-flex">
                  <label for="phone" class="mr-3 font-bold">Téléphone :</label>
                  <p readonly disabled>
                    {{ address.phone }}
                  </p>
                </div>
              </div>
              <div class="otherInformation">
                <label for="addressFieldInformation" class="font-bold"
                  >Informations complémentaires</label
                >
                <textarea
                  class="form-control mt-3"
                  v-model="address.addressFieldInformation"
                  placeholder="Informations complémentaires"
                  rows="3"
                  disabled
                  readonly
                ></textarea>
              </div>
              <div class="actions">
                <button
                  @click="cancelEdition"
                  v-if="editingField"
                  class="btn mr-5"
                >
                  Annuler
                </button>
                <button
                  @click="editAddress(index)"
                  v-if="!editingField"
                  class="btn mr-5"
                >
                  Éditer
                </button>
                <button @click="deleteAddress(index)" class="btn color-red">
                  Supprimer
                </button>
              </div>
            </div>
          </div>

          <!-- Buttons -->
          <button
            class="btn"
            :class="addingField && !editingField ? 'mb-5' : ''"
            v-if="addingField && !editingField"
            @click="cancelAddition"
          >
            Annuler l'ajout
          </button>
          <button
            class="btn"
            :class="!addingField && !editingField ? 'mb-5' : ''"
            v-if="!addingField && !editingField"
            @click="addNewFieldClick"
          >
            Ajouter une adresse
          </button>
          <button
            class="btn"
            :class="editingField ? 'mb-5' : ''"
            v-if="editingField"
            @click="cancelEdition"
          >
            Annuler l'édition
          </button>

          <!-- Adding -->
          <div class="form" v-if="addingField && !editingField">
            <input
              class="form-control"
              type="text"
              v-model="newAddress.firstname"
              id="firstname"
              placeholder="Prénom"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.lastname"
              id="lastname"
              placeholder="Nom"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.addressField"
              id="addressField"
              placeholder="Adresse"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.zipCode"
              id="zipCode"
              placeholder="Code postal"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.city"
              id="city"
              placeholder="Ville"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.country"
              id="country"
              placeholder="Pays"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.phone"
              id="phone"
              placeholder="Numéro de téléphone"
            />
            <textarea
              class="form-control mt-3"
              v-model="newAddress.addressFieldInformation"
              placeholder="Informations complémentaires"
              rows="3"
            ></textarea>
            <button
              class="btn"
              @click="addAddress"
              v-if="!editingField"
              :disabled="!isFormValid"
              :style="setValidFormClass"
            >
              Ajouter
            </button>
          </div>

          <!-- Edition -->
          <div class="form" v-if="editingField">
            <input
              class="form-control"
              type="text"
              v-model="newAddress.firstname"
              id="firstname"
              placeholder="Prénom"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.lastname"
              id="lastname"
              placeholder="Nom"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.addressField"
              id="addressField"
              placeholder="Adresse"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.zipCode"
              id="zipCode"
              placeholder="Code postal"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.city"
              id="city"
              placeholder="Ville"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.country"
              id="country"
              placeholder="Pays"
            />
            <input
              class="form-control"
              type="text"
              v-model="newAddress.phone"
              id="phone"
              placeholder="Numéro de téléphone"
            />
            <textarea
              class="form-control mt-3"
              v-model="newAddress.addressFieldInformation"
              placeholder="Informations complémentaires"
              rows="3"
            ></textarea>
            <button
              class="btn"
              @click="updateAddress(index)"
              :disabled="!isFormValid"
              :style="setValidFormClass"
            >
              Éditer
            </button>
          </div>
        </legend>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
#addresses {
  h1 {
    font-size: 24px;
  }

  .is-invalid {
    cursor: not-allowed;
  }

  .addresses {
    height: 100%;
    overflow: auto;
  }

  .address {
    width: 100%;
    background-color: #f2f2f2;
    margin: 20px 0;
    padding: 20px;
    font-size: 16px;
  }

  .personalInformation {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .d-flex {
    display: flex;
  }

  .address h3 {
    margin: 0;
  }

  .address p {
    margin: 0;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }

  .actions {
    display: flex;
  }

  .form-control:focus {
    outline: none;
    border-color: #3490dc;
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
