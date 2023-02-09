<script setup>
import Header from "../Header.vue";
import Sidebar from "./Sidebar.vue";
import { ref, computed } from "vue";
import axios from "axios";
import { createToast } from "mosha-vue-toastify";

// Only using to debug and test
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
const errors = ref({
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

const isFirstName = () => {
  const firstname = newAddress.value.firstname;

  if (firstname.length < 3) {
    errors.value.firstname = "Le prénom doit contenir au moins 3 caractères";
  } else {
    errors.value.firstname = "";
  }
};

const isLastName = () => {
  const lastname = newAddress.value.lastname;

  if (lastname.length < 3) {
    errors.value.lastname = "Le nom doit contenir au moins 3 caractères";
  } else {
    errors.value.lastname = "";
  }
};

const isAddressField = () => {
  const addressField = newAddress.value.addressField;

  if (addressField.length < 10) {
    errors.value.addressField =
      "L'adresse doit contenir au moins 10 caractères";
  } else {
    errors.value.addressField = "";
  }
};

const isZipCode = () => {
  const zipCode = newAddress.value.zipCode;
  const regex = new RegExp("^[0-9]{5}$");

  if (!regex.test(zipCode)) {
    errors.value.zipCode = "Le code postal n'est pas valide";
  } else {
    errors.value.zipCode = "";
  }
};

const isCity = () => {
  const city = newAddress.value.city;

  if (city.length < 3) {
    errors.value.city = "La ville doit contenir au moins 3 caractères";
  } else {
    errors.value.city = "";
  }
};

const isCountry = () => {
  const country = newAddress.value.country;

  if (country.length < 3) {
    errors.value.country = "Le pays doit contenir au moins 3 caractères";
  } else {
    errors.value.country = "";
  }
};

const isPhone = () => {
  const phone = newAddress.value.phone;
  const regex = new RegExp("^[0-9]{10}$");

  if (!regex.test(phone)) {
    errors.value.phone = "Le numéro de téléphone n'est pas valide";
  } else {
    errors.value.phone = "";
  }
};

const addAddress = () => {
  axios
    .post("https://localhost/addresses", newAddress.value, {
      headers: {
        Authorization:
          "Bearer " +
          `${localStorage.getItem("app-token").split('"').join("")}`,
      },
    })
    .then((response) => {
      if (response.status === 201) {
        addresses.value.push({
          id: response.data.id,
          firstname: response.data.firstname,
          lastname: response.data.lastname,
          phone: response.data.phone,
          addressField: response.data.addressField,
          addressFieldInformation: response.data.addressFieldInformation,
          zipCode: response.data.zipCode,
          city: response.data.city,
          country: response.data.country,
        });
        setToast("Addresse ajoutée avec succès", "success");
      }
    })
    .catch(() =>
      setToast("Une erreur est survenue lors de l'ajout de l'adresse", "danger")
    );

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
  axios
    .put(
      `https://localhost/addresses/${addresses.value[addressIndex.value].id}`,
      newAddress.value,
      {
        headers: {
          Authorization:
            "Bearer " +
            `${localStorage.getItem("app-token").split('"').join("")}`,
        },
      }
    )
    .then((response) => {
      if (response.status === 200) {
        addresses.value[addressIndex.value].firstname = response.data.firstname;
        addresses.value[addressIndex.value].lastname = response.data.lastname;
        addresses.value[addressIndex.value].addressField =
          response.data.addressField;
        addresses.value[addressIndex.value].zipCode = response.data.zipCode;
        addresses.value[addressIndex.value].city = response.data.city;
        addresses.value[addressIndex.value].country = response.data.country;
        addresses.value[addressIndex.value].phone = response.data.phone;
        addresses.value[addressIndex.value].addressFieldInformation =
          response.data.addressFieldInformation;
        setToast("Addresse modifiée avec succès", "success");
      }
    })
    .catch(() => {
      setToast(
        "Une erreur est survenue lors de la modification de l'adresse",
        "danger"
      );
    });

  resetFormFields();
  editingField.value = false;
};

const deleteAddress = (index) => {
  axios
    .delete(`https://localhost/addresses/${addresses.value[index].id}`, {
      headers: {
        Authorization:
          "Bearer " +
          `${localStorage.getItem("app-token").split('"').join("")}`,
      },
    })
    .then((response) => {
      if (response.status === 204) {
        addresses.value.splice(index, 1);
        setToast("Addresse supprimée avec succès", "success");
      }
    })
    .catch(() => {
      setToast(
        "Une erreur est survenue lors de la suppression de l'adresse",
        "danger"
      );
    });
};

const isFormValid = computed(() => {
  if (
    errors.value.firstname === "" &&
    errors.value.lastname === "" &&
    errors.value.addressField === "" &&
    errors.value.zipCode === "" &&
    errors.value.city === "" &&
    errors.value.country === "" &&
    errors.value.phone === "" &&
    newAddress.value.firstname !== "" &&
    newAddress.value.lastname !== "" &&
    newAddress.value.addressField !== "" &&
    newAddress.value.zipCode !== "" &&
    newAddress.value.city !== "" &&
    newAddress.value.country !== "" &&
    newAddress.value.phone !== ""
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

const getAddresses = () => {
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
      addresses.value = res?.data["hydra:member"];
      // addresses.value = dataUsingToTest["hydra:member"];
    })
    .catch(() =>
      setToast("Une erreur est survenue lors du chargement", "danger")
    );
};

getAddresses();
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <section id="addresses">
    <Sidebar />
    <div class="content">
      <div class="addresses">
        <legend>
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
                  class="form-control"
                  :value="address.addressFieldInformation"
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
              @input="isFirstName"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.firstname">
              {{ errors.firstname }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.lastname"
              id="lastname"
              placeholder="Nom"
              @input="isLastName"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.lastname">
              {{ errors.lastname }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.addressField"
              id="addressField"
              placeholder="Adresse"
              @input="isAddressField"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.addressField">
              {{ errors.addressField }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.zipCode"
              id="zipCode"
              placeholder="Code postal"
              @input="isZipCode"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.zipCode">
              {{ errors.zipCode }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.city"
              id="city"
              placeholder="Ville"
              @input="isCity"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.city">
              {{ errors.city }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.country"
              id="country"
              placeholder="Pays"
              @input="isCountry"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.country">
              {{ errors.country }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.phone"
              id="phone"
              placeholder="Numéro de téléphone"
              @input="isPhone"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.phone">
              {{ errors.phone }}
            </p>
            <textarea
              class="form-control"
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
              @input="isFirstName"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.firstname">
              {{ errors.firstname }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.lastname"
              id="lastname"
              placeholder="Nom"
              @input="isLastName"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.lastname">
              {{ errors.lastname }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.addressField"
              id="addressField"
              placeholder="Adresse"
              @input="isAddressField"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.addressField">
              {{ errors.addressField }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.zipCode"
              id="zipCode"
              placeholder="Code postal"
              @input="isZipCode"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.zipCode">
              {{ errors.zipCode }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.city"
              id="city"
              placeholder="Ville"
              @input="isCity"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.city">
              {{ errors.city }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.country"
              id="country"
              placeholder="Pays"
              @input="isCountry"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.country">
              {{ errors.country }}
            </p>
            <input
              class="form-control"
              type="text"
              v-model="newAddress.phone"
              id="phone"
              placeholder="Numéro de téléphone"
              @input="isPhone"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.phone">
              {{ errors.phone }}
            </p>
            <textarea
              class="form-control"
              v-model="newAddress.addressFieldInformation"
              placeholder="Informations complémentaires"
              rows="3"
            ></textarea>
            <button
              class="btn"
              @click="updateAddress"
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
    margin: 0 0 20px 0;
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

  .messageErrors {
    color: red;
    font-size: 12px;
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
