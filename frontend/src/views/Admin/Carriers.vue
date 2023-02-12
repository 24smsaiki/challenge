<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import CarriersLogic from "../../logics/CarriersLogic";
import { ref } from "vue";

const carriers = ref([]);
let columns = ref([]);

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
    <Table :columns="columns" :data="carriers" />
</template>