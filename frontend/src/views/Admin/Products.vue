<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import ProductsLogic from "../../logics/ProductsLogic";
import { ref } from "vue";

const products = ref([]);
let columns = ref([]);

ProductsLogic.getProducts().then((response) => {
  products.value = response.data;
 columns = Object.keys(products.value[0]);

});



</script>



<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
    <Header />
    
<Table :columns="columns" :data="products" />
</template>