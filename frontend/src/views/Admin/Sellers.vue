<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import UsersLogic from "../../logics/UsersLogic";
import { ref } from "vue";
import moment from "moment";

const sellers = ref([]);
let columns = ref([]);

UsersLogic.getSellers().then((response) => {
  sellers.value = response;
  columns = Object.keys(sellers.value[0]);
});

</script>

<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
    <Header />
    <Table :columns="columns" :data="sellers" />
</template>

