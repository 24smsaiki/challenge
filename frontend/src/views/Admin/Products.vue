<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import ProductsLogic from "../../logics/ProductsLogic";
import { ref, reactive } from "vue";
import { createToast } from "mosha-vue-toastify";

const products = ref([]);
let columns = ref([]);
const isEditing = ref(false);

const errors = reactive({
    label: "",
    description: "",
    price: "",
    // image: "",
    // coverImage: "",
    stockQuantity: "",

});

const form = ref({
    id: null,
    label: "",
    description: "",
    price: "",
    stockQuantity: "",
    // image: "",
    // coverImage: "",
});

const isFormValid = () => {
    if(
        form.value.label !== "" &&
        form.value.description !== "" &&
        form.value.price !== "" &&
        form.value.stockQuantity !== ""
        // form.value.image !== "" &&
        // form.value.coverImage !== ""
    ) {
        return true;
    } else {
        return false;
    }
};

const isLabel = () => {
    const label = form.value.label;
    if(label.length < 3) {
        errors.label = "Le label doit contenir au moins 3 caractères.";
    } else {
        errors.label = "";
    }
};

const isDescription = () => {
    const description = form.value.description;
    if(description.length < 10) {
        errors.description = "La description doit contenir au moins 10 caractères.";
    } else {
        errors.description = "";
    }
};

const isPrice = () => {
    const price = form.value.price;
    if(price <= 0) {
        errors.price = "Le prix doit être supérieur à 0.";
    } else {
        errors.price = "";
    }
};

const onFileChange = (e) => {
    const file = e.target.files[0];
    form.value.image = file;
    // save file in src/products

    console.log(import.meta.env.VITE_BASE_URL, "VITE_BASE_URL");
};

const isStockQuantity = () => {
    const stockQuantity = form.value.stockQuantity;
    if(stockQuantity <= 0) {
        errors.stockQuantity = "La quantité doit être supérieure à 0.";
    } else {
        errors.stockQuantity = "";
    }
};

const onSubmit = (e) => {
    e.preventDefault();
    
    if(isFormValid()) {
        if(form.value.id) {
            ProductsLogic.updateProduct(form.value.id, form.value)
            .then((response) => {
                
                isEditing.value = false;
                products.value = products.value.map((product) => {
                    if(product.id === response.data.id) {
                        return response.data;
                    } else {
                        return product;
                    }
                });
                resetForm();
            });
        } else {
            ProductsLogic.createProduct(form.value)
            .then((response) => {
                isEditing.value = false;
                products.value.push(response.data);
                resetForm();
            });
        }
       
    } 
};

// Permet de gérer si on est en mode édition/création ou non
const onEdit = (data) => {
    isEditing.value = data;
};

// Remet à zéro le formulaire
const resetForm = () => {
    form.value.id = "";
    form.value.label = "";
    form.value.description = "";
    form.value.price = "";
    form.value.image = "";
    form.value.stockQuantity = "";
    // form.value.coverImage = "";
    isEditing.value = false;
};

// Rempli le formulaire avec les données de l'objet passé en paramètre
const editForm = (data) => {

    form.value.id = data?.id;
    form.value.label = data.label;
    form.value.description = data.description;
    form.value.price = data.price;
    form.value.stockQuantity = data.stockQuantity;
    // form.value.image = data.image;
    // form.value.coverImage = data.coverImage;
    isEditing.value = true;
};

// Supprime un produit
const onDelete = (data) => {
    ProductsLogic.deleteProduct(data.id)
    .then(() => {
        products.value = products.value.filter((product) => product.id !== data.id);
        createToast("Produit supprimé", {
            type: "success",
            position: "top-right",
            timeout: 3000,
        });
        resetForm();
    }).catch(() => {
        createToast("Quelque chose s'est mal passé", {
            type: "danger",
            position: "top-right",
            timeout: 3000,
        });
    })
};

ProductsLogic.getProducts().then((response) => {
  products.value = response.data;
  columns = Object.keys(products.value[0]);
});
</script>

<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
  <Header />

  <Table v-if="!isEditing" @onEdit="onEdit"  :isEditing="isEditing" @onDelete="onDelete" @editForm="editForm" :columns="columns" :data="products" />
  <template v-else>
    <div
      class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2"
      style="margin-top: 37px"
    >
    <!-- icon to change isEditing -->
        <div class="flex justify-end">
            <button @click="resetForm">
            <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
                ></path>
            </svg>
            </button>
        </div>
      <div class="-mx-3 md:flex mb-6">
        <div class="md:w-1/3 px-3 mb-6 md:mb-0">
            <label
                class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                for="grid-label"
            >
                Label
            </label>
            <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3"
                id="grid-label"
                type="text"
                v-model="form.label"
                placeholder="Label"
                @input="isLabel"
            />
            <p class="messageErrors" v-if="errors.label">{{ errors.label }}</p>
         
        </div>
        <div class="md:w-1/3 px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-price">
                Price
            </label>
            <input 
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" 
                id="grid-price" 
                type="number" 
                v-model="form.price"
                placeholder="Price"
                @input="isPrice"
            />
            <p class="messageErrors" v-if="errors.price">{{ errors.price }}</p>
        </div>
        <div class="md:w-1/3 px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-stockQuantity">
                Stock Quantity
            </label>
            <input 
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" 
                id="grid-stockQuantity" 
                type="number" 
                v-model="form.stockQuantity"
                placeholder="Stock Quantity"
                @input="isStockQuantity"
            />
            <p class="messageErrors" v-if="errors.stockQuantity">{{ errors.stockQuantity }}</p>
        </div>
        
      </div>
        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-full px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-description">
                    Description
                </label>
                <textarea 
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-description" 
                    row="3"
                    v-model="form.description"
                    placeholder="Description"
                    @input="isDescription"
                />
                <p class="messageErrors" v-if="errors.description">{{ errors.description }}</p>
            </div>
            </div>      
      <!-- <div class="-mx-3 md:flex mb-6">
        <div class="md:w-full px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-description">
                Image 
            </label>
            <input 
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                id="grid-description" 
                v-on:change="onFileChange"
                type="file"
                placeholder="Image"
                @input="isImage"
            />
            <p class="messageErrors" v-if="errors.image">{{ errors.image }}</p>
        </div>
        </div> -->
        <button @click="onSubmit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Envoyer
        </button>
    </div>
    
  </template>
</template>

<style scoped>
.messageErrors {
  color: red;
  font-size: 14px;
}
</style>