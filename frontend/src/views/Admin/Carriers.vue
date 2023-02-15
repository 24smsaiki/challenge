<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import CarriersLogic from "../../logics/CarriersLogic";
import { ref, reactive } from "vue";
import { createToast } from "mosha-vue-toastify";

const carriers = ref([]);
let columns = ref([]);
const isEditing = ref(false);

const errors = reactive({
    label: "",
    fees: 0,
});

const form = ref({
    id: null,
    label: "",
    fees: 0,
});

const isFormValid = () => {
    if(
        form.value.label !== "" &&
        form.value.fees !== ""
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

const isFees = () => {
    const fees = form.value.fees;
    if(fees < 0) {
        errors.fees = "Les frais ne peuvent pas être négatifs.";
    } else {
        errors.fees = "";
    }
};

const onEdit = (data) => {
    isEditing.value = true;
};

const resetForm = () => {
    form.value = {
        id: null,
        label: "",
        fees: 0,
    };
   isEditing.value = false;
};

const editForm = (data) => {
    form.value = {
        id: data.id,
        label: data.label,
        fees: data.fees,
    };
    isEditing.value = true;
};

const onDelete = async (data) => {
    await CarriersLogic.deleteCarrier(data.id)
    .then(() => {
        carriers.value = carriers.value.filter((carrier) => carrier.id !== data.id);
        createToast("Le transporteur a bien été supprimé.", {
            type: "success",
            position: "top-right",
            timeout: 3000,
        });
        resetForm();
    });
};


const onSubmit = async () => {
    if(isFormValid()) {
            await CarriersLogic.createCarrier(form.value)
            .then((response) => {
                createToast("Le transporteur a bien été ajouté.", {
                    type: "success",
                    position: "top-right",
                    timeout: 3000,
                });
                isEditing.value = false;
                carriers.value.push(response.data);
                resetForm();
            })
            .catch(() => {
                createToast("Une erreur est survenue.", {
                    type: "danger",
                    position: "top-right",
                    timeout: 3000,
                });
            });
    } else {
        createToast("Veuillez remplir tous les champs.", {
            type: "danger",
            position: "top-right",
            timeout: 3000,
        });
    }
};
CarriersLogic.getCarriers().then((response) => {
    response.data.forEach((carrier) => {
        carrier.orders = carrier.orders.length;
    });
  carriers.value = response.data;
  columns = Object.keys(carriers.value[0]);
});



</script>

<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
    <Header />
    <Table v-if="!isEditing" @onEdit="onEdit" :isEditing="isEditing" :columns="columns" :data="carriers" @onDelete="onDelete" @editForm="editForm" />
   <template class="flex flex-wrap" v-else>
        <div class="flex flex-wrap">
            <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                <div class="bg-white border-transparent rounded-lg shadow-xl">
                    <div class="bg-gray-800 text-white text-xl uppercase text-center font-bold p-3">
                        Ajouter un transporteur
                    </div>
                    <div class="p-5">
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
                        <div class="flex flex-wrap">
                            <div class="w-full p-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="label">
                                    Label
                                </label>
                                <input
                                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="label"
                                    type="text"
                                    placeholder="Label"
                                    v-model="form.label"
                                    @input="isLabel"
                                />
                                <p class="text-red-500 text-xs italic" v-if="errors.label !== ''">{{ errors.label }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-full p-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="fees">
                                    Frais
                                </label>
                                <input
                                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="fees"
                                    type="number"
                                    placeholder="Frais"
                                    v-model="form.fees"
                                    @input="isFees"
                                />
                                <p class="text-red-500 text-xs italic" v-if="errors.fees">{{ errors.fees }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-full p-6">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    type="button"
                                    @click="onSubmit"
                                >
                                    Ajouter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </template>
    
</template>