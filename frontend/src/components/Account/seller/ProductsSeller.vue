<script setup>
import Header from "../../Header.vue";
import Sidebar from "./SidebarSeller.vue";
import { ref, computed } from "vue";
import { createToast } from "mosha-vue-toastify";
import ProductsLogic from "../../../logics/ProductsLogic";

const products = ref([]);
const newProduct = ref({
  label: "",
  description: "",
  price: "",
  stockQuantity: 0,
});
const errors = ref({
  label: "",
  price: "",
  stockQuantity: "",
});

const addingField = ref(false);
const editingField = ref(false);
const productIndex = ref(0);

const addNewFieldClick = () => (addingField.value = !addingField.value);

const resetFormFields = () => {
  newProduct.value.label = "";
  newProduct.value.description = "";
  newProduct.value.price = "";
  newProduct.value.stockQuantity = 0;
};

function setToast(message, type) {
  createToast(message, {
    position: "top-right",
    timeout: 5000,
    close: true,
    type: type,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
  });
}

const isLabel = () => {
  const label = newProduct.value.label;

  if (label.length < 3) {
    errors.value.label = "Le nom doit contenir au moins 3 caractères";
  } else {
    errors.value.label = "";
  }
};

const isPrice = () => {
  const price = newProduct.value.price;
  const regex = new RegExp("^[0-9]{1,5}$");

  if (!regex.test(price)) {
    errors.value.price = "Le prix n'est pas valide";
  } else {
    errors.value.price = "";
  }
};

const isQuantity = () => {
  const stockQuantity = newProduct.value.stockQuantity;
  const regex = new RegExp("^[0-9]{1,5}$");

  if (!regex.test(stockQuantity) && stockQuantity !== 0) {
    errors.value.stockQuantity = "La quantité n'est pas valide";
  } else {
    errors.value.stockQuantity = "";
  }
};

const addProduct = () => {
  if (isFormValid.value === true) {
    const newProductFormat = {
      label: newProduct.value.label,
      description: newProduct.value.description,
      price: Number(newProduct.value.price),
      stockQuantity: Number(newProduct.value.stockQuantity),
    };

    ProductsLogic.createProduct(newProductFormat)
      .then((response) => {
        if (response.status === 201) {
          products.value.push({
            id: response.data.id,
            label: response.data.label,
            description: response.data.description,
            price: response.data.price,
            stockQuantity: response.data.stockQuantity,
          });
          setToast("Produit ajoutée avec succès", "success");
        }
      })
      .catch(() =>
        setToast("Une erreur est survenue lors de l'ajout du produit", "danger")
      );

    resetFormFields();
    addingField.value = false;
  }
};

const editProduct = (index) => {
  editingField.value = !editingField.value;
  productIndex.value = index;
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
  newProduct.value.label = products.value[productIndex.value].label;
  newProduct.value.description = products.value[productIndex.value].description;
  newProduct.value.price = products.value[productIndex.value].price;
  newProduct.value.stockQuantity =
    products.value[productIndex.value].stockQuantity;
};

const updateProduct = () => {
  if (isFormValid.value === true) {
    ProductsLogic.updateProduct(
      products.value[productIndex.value].id,
      newProduct.value
    )
      .then((response) => {
        if (response.status === 200) {
          products.value[productIndex.value].label = response.data.label;
          products.value[productIndex.value].description =
            response.data.description;
          products.value[productIndex.value].price = response.data.price;
          products.value[productIndex.value].stockQuantity = Number(
            response.data.stockQuantity
          );
          setToast("Produit modifiée avec succès", "success");
        }
      })
      .catch(() => {
        setToast(
          "Une erreur est survenue lors de la modification du produit",
          "danger"
        );
      });

    resetFormFields();
    editingField.value = false;
  }
};

const deleteProduct = (index) => {
  ProductsLogic.deleteProduct(products.value[index].id)
    .then((response) => {
      if (response.status === 204) {
        products.value.splice(index, 1);
        setToast("Produit supprimée avec succès", "success");
      }
    })
    .catch(() => {
      setToast(
        "Une erreur est survenue lors de la suppression du produit",
        "danger"
      );
    });
};

const isFormValid = computed(() => {
  if (
    errors.value.label === "" &&
    errors.value.price === "" &&
    errors.value.stockQuantity === "" &&
    newProduct.value.label !== "" &&
    newProduct.value.price !== "" &&
    newProduct.value.stockQuantity !== 0
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

const getProducts = () => {
  ProductsLogic.getProducts()
    .then((response) => {
      if (response.status === 200) {
        products.value = response?.data;
      }
    })
    .catch(() =>
      setToast(
        "Une erreur est survenue lors du chargement des produits",
        "danger"
      )
    );
};

getProducts();
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <section id="products">
    <Sidebar />
    <div class="content">
      <div class="products">
        <legend>
          <!-- Data -->
          <div v-for="(product, index) in products" :key="index">
            <div v-if="!editingField && !addingField" class="product">
              <div class="form-group mb-3">
                <label for="label" class="mr-3 font-bold">Nom :</label>
                <p readonly disabled>
                  {{ product.label }}
                </p>
              </div>
              <div class="form-group mb-3 d-flex flex-column">
                <label for="description" class="font-bold"
                  >Description du produit</label
                >
                <textarea
                  class="form-control mt-3"
                  :value="product.description"
                  placeholder="Description du produit"
                  rows="3"
                  disabled
                  readonly
                ></textarea>
              </div>
              <div class="form-group mb-3 d-flex">
                <label for="price" class="mr-3 font-bold">Prix :</label>
                <p readonly disabled>{{ product.price }} €</p>
              </div>
              <div class="form-group mb-3 d-flex">
                <label for="label" class="mr-3 font-bold">Quantité :</label>
                <p readonly disabled>
                  {{ product.stockQuantity }}
                </p>
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
                  @click="editProduct(index)"
                  v-if="!editingField"
                  class="btn mr-5"
                >
                  Éditer
                </button>
                <button @click="deleteProduct(index)" class="btn color-red">
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
            Ajouter un produit
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
              v-model="newProduct.label"
              id="label"
              placeholder="Nom"
              @input="isLabel"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.label">
              {{ errors.label }}
            </p>
            <textarea
              class="form-control"
              v-model="newProduct.description"
              placeholder="Description du produit"
              rows="3"
            ></textarea>
            <input
              class="form-control"
              type="text"
              v-model="newProduct.price"
              id="price"
              placeholder="Prix"
              @input="isPrice"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.price">
              {{ errors.price }}
            </p>
            <input
              class="form-control"
              type="number"
              v-model="newProduct.stockQuantity"
              id="stockQuantity"
              placeholder="Quantité"
              @input="isQuantity"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.stockQuantity">
              {{ errors.stockQuantity }}
            </p>
            <button
              class="btn"
              @click="addProduct"
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
              v-model="newProduct.label"
              id="label"
              placeholder="Nom"
              @input="isLabel"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.label">
              {{ errors.label }}
            </p>
            <textarea
              class="form-control"
              v-model="newProduct.description"
              placeholder="Description du produit"
              rows="3"
            ></textarea>
            <input
              class="form-control"
              type="text"
              v-model="newProduct.price"
              id="price"
              placeholder="Prix"
              @input="isPrice"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.price">
              {{ errors.price }}
            </p>
            <input
              class="form-control"
              type="number"
              v-model="newProduct.stockQuantity"
              id="stockQuantity"
              placeholder="Quantité"
              @input="isQuantity"
            />
            <p class="messageErrors mb-3 ml-0" v-if="errors?.stockQuantity">
              {{ errors.stockQuantity }}
            </p>
            <button
              class="btn"
              @click="updateProduct"
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
#products {
  .is-invalid {
    cursor: not-allowed;
  }

  .products {
    height: 100%;
    overflow: auto;
  }

  .product {
    width: 100%;
    background-color: #f2f2f2;
    margin: 0 0 20px 0;
    padding: 20px;
    font-size: 16px;
  }

  .d-flex {
    display: flex;
  }

  .messageErrors {
    color: red;
    font-size: 12px;
  }

  .flex-column {
    flex-direction: column;
  }

  .product h3 {
    margin: 0;
  }

  .product p {
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
