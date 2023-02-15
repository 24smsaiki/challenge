<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import UsersLogic from "../../logics/UsersLogic";
import { ref, reactive } from "vue";
import moment from "moment";
import AddressesLogic from "../../logics/AddressesLogic";
import { createToast } from "mosha-vue-toastify";

const users = ref([]);
let columns = ref([]);
const isEditing = ref(false);

const errors = reactive({
    id: "",
    email: "",
    firstname: "",
    lastname: "",
});

const form = ref({
    id: null,
    email: "",
    isActif: "",
    firstname: "",
    lastname: "",
    roles: "",

});

const isFormValid = () => {
    if(
        form.value.email !== "" &&
        form.value.isActif !== "" &&
        form.value.firstname !== "" &&
        form.value.lastname !== ""
    ) {
        return true;
    } else {
        return false;
    }
};

const isEmail = () => {
    const email = form.value.email;
    if(email.length < 3) {
        errors.email = "L'email doit contenir au moins 3 caractères.";
    } else {
        errors.email = "";
    }
};

const isFirstname = () => {
    const firstname = form.value.firstname;
    if(firstname.length < 3) {
        errors.firstname = "Le prénom doit contenir au moins 3 caractères.";
    } else {
        errors.firstname = "";
    }
};

const isLastname = () => {
    const lastname = form.value.lastname;
    if(lastname.length < 3) {
        errors.lastname = "Le nom doit contenir au moins 3 caractères.";
    } else {
        errors.lastname = "";
    }
};

const onEdit = (data) => {
    isEditing.value = data;
}

const resetForm = () => {
    form.value.id = null;
    form.value.email = "";
    form.value.isActif = "";
    form.value.firstname = "";
    form.value.lastname = "";
    form.value.roles = "";
    isEditing.value = false;
};

const editForm = (data) => {
    form.value.id = data.id;
    form.value.email = data.email;
    form.value.isActif = data.isActif;
    form.value.firstname = data.firstname;
    form.value.lastname = data.lastname;
    form.value.roles = data.roles;
};

const onSubmit = () => {
    if(isFormValid()) {
            UsersLogic.createUser(form.value).then((response) => {
                if(response.status === 201) {
                    resetForm();
                    getUsers();
                    createToast("L'utilisateur a bien été créé.", {
                        type: "success",
                        position: "top-right",
                        timeout: 3000,
                    });
                }
            }).catch((error) => {
                createToast("Une erreur est survenue.", {
                    type: "danger",
                    position: "top-right",
                    timeout: 3000,
                });
            });
    }
};

const onDelete = (data) => {
    UsersLogic.deleteUser(data.id).then((response) => {
       getUsers();
       resetForm();       
       createToast("L'utilisateur a bien été supprimé.", {
           type: "success",
           position: "top-right",
           timeout: 3000,
       });
    }).catch((error) => {
        createToast("Une erreur est survenue.", {
            type: "danger",
            position: "top-right",
            timeout: 3000,
        });
    });
};

UsersLogic.getUsers().then((response) => {

    response.data.forEach((user) => {
        user.createdAt = moment(user.createdAt).format("DD/MM/YYYY");
        user.orders = user.orders.length;
        user.Address = user.Address.length;
    });
    
  users.value = response.data;
 columns = Object.keys(users.value[0]);

});

</script>

<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
    <Header />

<Table v-if="!isEditing" :isEditing="isEditing" @onEdit="onEdit" @onDelete="onDelete" @editForm="editForm" :columns="columns" :data="users" />
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
            email
            </label>
            <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3"
                id="grid-label"
                type="text"
                v-model="form.email"
                placeholder="email"
                @input="isEmail"
                disabled
            />
            <p class="messageErrors" v-if="errors.email">{{ errors.email }}</p>
         
        </div>
        <div class="md:w-1/3 px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-price">
                Actif
            </label>
            <input 
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" 
                id="grid-Actif" 
                type="number" 
                v-model="form.isActif"
                placeholder="Actif"
                @input="isActif"
            />
            <p class="messageErrors" v-if="errors.isActif">{{ errors.isActif }}</p>
        </div>
        <div class="md:w-1/3 px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-stockQuantity">
                Roles
            </label>
            <!-- select multiple values -->
            <select
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                id="grid-roles"
                v-model="form.roles"
                @input="isRoles"
            >
                <option value="ROLE_USER">ROLE_USER</option>
                <option value="ROLE_ADMIN">ROLE_SELLER</option>
            </select>
            <p class="messageErrors" v-if="errors.roles">{{ errors.roles }}</p>
        </div>
        
      </div>
        <div class="-mx-3 md:flex mb-6">
            <div class="md:w-full px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-description">
                    Prénom
                </label>
                <input 
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-firstname" 
                    type="text" 
                    v-model="form.firstname"
                    placeholder="Prénom"
                    @input="isFirstname"
                />
                <p class="messageErrors" v-if="errors.firstname">{{ errors.firstname }}</p>
            </div>
            <div class="md:w-full px-3">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-description">
                    Nom
                </label>
                <input 
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-lastname" 
                    type="text" 
                    v-model="form.lastname"
                    placeholder="Nom"
                    @input="isLastname"
                />
                <p class="messageErrors" v-if="errors.lastname">{{ errors.lastname }}</p>
            </div>
            </div>      

        <button @click="onSubmit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Envoyer
        </button>
    </div>
    
  </template>


</template>