<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import OrdersLogic from "../../logics/OrdersLogic";
import { ref } from "vue";
import CarriersLogic from "../../logics/CarriersLogic";
import moment from "moment";

const orders = ref([]);
let columns = ref([]);
const carriers = ref([]);

const getCarriers = async () => {
    return await CarriersLogic.getCarriers().then((response) => {
        carriers.value = response.data;
    });
};

OrdersLogic.getOrders().then((response) => {
    
    response.data.forEach((order) => {
        const id = order.carrier.split("/").pop();
        const carrier = carriers.value.filter((carrier) => carrier.id == id)[0];
        order.carrier = carrier.label;
        order.createdAt = moment(order.createdAt).format("DD/MM/YYYY");
    });

    response.data.map((order) => {
        return {
            id: order.id,
            name: order.name,
            reference: order.reference,
            total: order.total,
            isPaid: order.isPaid,
            createdAt: order.createdAt
        };
    });

    // supprimer les propriétés orderDetails, customer, delivery
    response.data.forEach((order) => {
        delete order.orderDetails;
        delete order.customer;
        delete order.delivery;
    });

    console.log(response.data);
    orders.value = response.data;
    columns = Object.keys(orders.value[0]);
   
});

getCarriers();

</script>

<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
    <Header />
    <Table :data="orders" :columns="columns" />
</template>
