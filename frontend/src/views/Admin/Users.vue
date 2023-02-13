<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import UsersLogic from "../../logics/UsersLogic";
import { ref, reactive } from "vue";
import moment from "moment";
import AddressesLogic from "../../logics/AddressesLogic";

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
        if(form.value.id) {
            UsersLogic.updateUser(form.value).then((response) => {
                if(response.status === 200) {
                    resetForm();
                    isEditing.value = false;
                    getUsers();
                }
            });
        } else {
            UsersLogic.createUser(form.value).then((response) => {
                if(response.status === 201) {
                    resetForm();
                    isEditing.value = false;
                    getUsers();
                }
            });
        }
    }
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

<Table :columns="columns" :data="users" />
</template>