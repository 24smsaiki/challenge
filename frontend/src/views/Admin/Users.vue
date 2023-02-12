<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import UsersLogic from "../../logics/UsersLogic";
import { ref } from "vue";
import moment from "moment";
import AddressesLogic from "../../logics/AddressesLogic";

const users = ref([]);
let columns = ref([]);


UsersLogic.getUsers().then((response) => {

    response.data.forEach((user) => {
        user.createdAt = moment(user.createdAt).format("DD/MM/YYYY");
        user.orders = user.orders.length;
        user.Address = user.Address.length;
    });
    

    console.log(response.data, "users");

  users.value = response.data;
 columns = Object.keys(users.value[0]);

});

</script>

<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
    <Header />

<Table :columns="columns" :data="users" />
</template>