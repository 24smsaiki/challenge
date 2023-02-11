<script setup >
import { ref, computed, watch, onMounted } from 'vue'
import OrdersLogic from '../../logics/OrdersLogic';
import ProductsLogic from '../../logics/ProductsLogic';
import CarriersLogic from '../../logics/CarriersLogic';

const Orders = ref([]);
const Products = ref([]);
const Carriers = ref([]);

const fetchCarriers = async () => {
  const response = await CarriersLogic.getCarriers();
  Carriers.value = response.data;
};

const fetchOrders = async () => {
  const response = await OrdersLogic.getOrders();
  Orders.value = response.data;
};

const fetchProducts = async () => {
  const response = await ProductsLogic.getProducts();
  Products.value = response.data;
};


onMounted(() => {
  fetchOrders();
  fetchProducts();
  fetchCarriers();
});


</script>

<template>
    <div class="container">
        <h1>{{Orders.length}} LENGTHS</h1>
        <div class="row">
        <div class="col-12">
            <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Order ID</th>
            
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col">Carrier</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in Orders" :key="order.id">
                <th scope="row">{{ order.id }}</th>
             
                <td>{{ order.total }}</td>
                <td>{{ order.status }}</td>
                <td>{{ order.carrier }}</td>
                <td>
                    <button class="btn btn-primary">Edit</button>
                    <button class="btn btn-danger">Delete</button>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>
</template>