<script setup>
import { ref, computed, onMounted, reactive } from 'vue';
import OrdersLogic from '../../logics/OrdersLogic';
import CarriersLogic from '../../logics/CarriersLogic';
import ProductsLogic from '../../logics/ProductsLogic';
import UsersLogic from '../../logics/UsersLogic';
import moment from "moment";

const orders = ref([]);
const carriers = ref([]);
const products = ref([]);
const users = ref([]);
const sellers = ref([]);
const requests = ref([]);

const fetchOrders = async () => {
  return await OrdersLogic.getOrders().then((response) => {
    orders.value = response.data;
    });
};

const fetchCarriers = async () => {
  return await CarriersLogic.getCarriers().then((response) => {
    carriers.value = response.data;
    });
};

const fetchProducts = async () => {
    return await ProductsLogic.getProducts().then((response) => {
        products.value = response.data;
        });
};

const fetchUsers = async () => {
    return await UsersLogic.getUsers().then((response) => {
        users.value = response.data;
        });
};

const fetchSellers = async () => {
    return await UsersLogic.getSellers().then((response) => {
        sellers.value = response;
        });
};

const fetchRequests = async () => {
    return await UsersLogic.getRequestSellers().then((response) => {
        requests.value = response;
        });
};



onMounted(() => {
  fetchOrders();
  fetchCarriers();
  fetchProducts();
  fetchUsers();
  fetchSellers();
  fetchRequests();
});


</script>

<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">

    <header>
        <!--Nav-->
        <nav aria-label="menu nav" class="bg-gray-800 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">
    
            <div class="flex flex-wrap items-center">
                <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
                    <a href="#" aria-label="Home">
                        <span class="text-xl pl-2"><i class="em em-grinning"></i></span>
                    </a>
                </div>
    
                <div class="flex flex-1 md:w-1/3 justify-center md:justify-start text-white px-2">
                    <span class="relative w-full">
                        <input aria-label="search" type="search" id="search" placeholder="Search" class="w-full bg-gray-900 text-white transition border border-transparent focus:outline-none focus:border-gray-400 rounded py-3 px-2 pl-10 appearance-none leading-normal">
                        <div class="absolute search-icon" style="top: 1rem; left: .8rem;">
                            <svg class="fill-current pointer-events-none text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                            </svg>
                        </div>
                    </span>
                </div>
    
                <div class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
                    <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                        <li class="flex-1 md:flex-none md:mr-3">
                            <a class="inline-block py-2 px-4 text-white no-underline" href="#">Active</a>
                        </li>
                        <li class="flex-1 md:flex-none md:mr-3">
                            <a class="inline-block text-gray-400 no-underline hover:text-gray-200 hover:text-underline py-2 px-4" href="#">link</a>
                        </li>
                        <li class="flex-1 md:flex-none md:mr-3">
                            <div class="relative inline-block">
                                <button class="drop-button text-white py-2 px-2"> <span class="pr-2"><i class="em em-robot_face"></i></span> Hi, User <svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg></button>
                                <div id="myDropdown" class="dropdownlist absolute bg-gray-800 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                                    <input type="text" class="drop-search p-2 text-gray-600" placeholder="Search.." id="myInput" >
                                    <a href="#" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-user fa-fw"></i> Profile</a>
                                    <a href="#" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-cog fa-fw"></i> Settings</a>
                                    <div class="border border-gray-800"></div>
                                    <a href="#" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
    
        </nav>
    </header>
    
    
    <main>
    
        <div class="flex flex-col md:flex-row">
            <nav aria-label="alternative nav">
                <div class="bg-gray-800 shadow-xl h-20 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48 content-center">
    
                    <div class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                        <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">
                            <li class="mr-3 flex-1">
                                <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                                    <i class="fas fa-tasks pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Tasks</span>
                                </a>
                            </li>
                            <li class="mr-3 flex-1">
                                <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                                    <i class="fa fa-envelope pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Messages</span>
                                </a>
                            </li>
                            <li class="mr-3 flex-1">
                                <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                                    <i class="fas fa-chart-area pr-0 md:pr-3 text-blue-600"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Analytics</span>
                                </a>
                            </li>
                            <li class="mr-3 flex-1">
                                <a href="#" class="block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                                    <i class="fa fa-wallet pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Payments</span>
                                </a>
                            </li>
                        </ul>
                    </div>
    
    
                </div>
            </nav>
            <section>
                <div style="margin-top: 37px;" id="main" class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">

                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                           
                            <div class="bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-xl p-5">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded-full p-5 bg-green-600"><i class="fa fa-wallet fa-2x fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h2 class="font-bold uppercase text-gray-600">Total commandes </h2>
                                       <p class="font-bold text-3xl"> 
                                       
                                        {{ orders ? orders.length : null}} <span class="text-green-500"><i class="fas fa-caret-up"></i></span></p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                           
                            <div class="bg-gradient-to-b from-pink-200 to-pink-100 border-b-4 border-pink-500 rounded-lg shadow-xl p-5">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded-full p-5 bg-pink-600"><i class="fas fa-users fa-2x fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h2 class="font-bold uppercase text-gray-600">Total produits</h2>
                                        <p class="font-bold text-3xl">{{ products ? products.length : 0 }} <span class="text-pink-500"><i class="fas fa-exchange-alt"></i></span></p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                           
                            <div class="bg-gradient-to-b from-yellow-200 to-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-xl p-5">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded-full p-5 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h2 class="font-bold uppercase text-gray-600"> total transporteurs</h2>
                                        <p class="font-bold text-3xl"> {{ carriers ? carriers.length : 0 }} <span class="text-yellow-600"><i class="fas fa-caret-up"></i></span></p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                           
                            <div class="bg-gradient-to-b from-blue-200 to-blue-100 border-b-4 border-blue-500 rounded-lg shadow-xl p-5">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded-full p-5 bg-blue-600"><i class="fas fa-server fa-2x fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h2 class="font-bold uppercase text-gray-600">Total users</h2>
                                        <p class="font-bold text-3xl">{{ users.length }}</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                           
                            <div class="bg-gradient-to-b from-indigo-200 to-indigo-100 border-b-4 border-indigo-500 rounded-lg shadow-xl p-5">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded-full p-5 bg-indigo-600"><i class="fas fa-tasks fa-2x fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h2 class="font-bold uppercase text-gray-600">Total revendeurs</h2>
                                        <p class="font-bold text-3xl">{{ sellers.length }}</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                           
                            <div class="bg-gradient-to-b from-red-200 to-red-100 border-b-4 border-red-500 rounded-lg shadow-xl p-5">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pr-4">
                                        <div class="rounded-full p-5 bg-red-600"><i class="fas fa-inbox fa-2x fa-inverse"></i></div>
                                    </div>
                                    <div class="flex-1 text-right md:text-center">
                                        <h2 class="font-bold uppercase text-gray-600">Demande revendeurs</h2>
                                        <p class="font-bold text-3xl">{{ requests.length }} <span class="text-red-500"><i class="fas fa-caret-up"></i></span></p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
    
    
                    <div class="flex flex-row flex-wrap flex-grow mt-2">
    
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h class="font-bold uppercase text-gray-600">Commandes</h>
                            </div>
                            <div class="p-5">
                                <table class="w-full p-5 text-gray-700">
                                    <thead>
                                        <tr>
                                            <th class="text-left text-blue-500">Reference</th>
                                            <th class="text-left text-blue-500">Date</th>
                                            <th class="text-left text-blue-500">Total</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="order in orders.slice(0, 10)">
                                
                                            <td class="text-left">{{ order.reference }}</td>
                                            <td class="text-left">{{ moment(order.date).format('DD/MM/YYYY') }}</td>
                                            <td class="text-left">{{ order.total }} €</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="py-2"><a href="#">Voir plus...</a></p>
                            </div>
                        </div>
                        
                    </div>
    
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">produits</h2>
                            </div>
                            <div class="p-5">
                                <table class="w-full p-5 text-gray-700">
                                    <thead>
                                        <tr>
                                            <th class="text-left text-blue-500">ID</th>
                                            <th class="text-left text-blue-500">Nom</th>
                                            <th class="text-left text-blue-500">Prix</th>
                                            <!-- <th class="text-left text-blue-500">Quantité</th> -->
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in products.slice(0, 11)">
                                            <td class="text-left">{{ product.id }}</td>
                                            <td class="text-left">{{ product.label }}</td>
                                            <td class="text-left">{{ product.price }} €</td>
                                            <!-- <td class="text-left">{{ product.quantity }}</td> -->
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="py-2"><a href="#">Voir plus...</a></p>
                            </div>
                        </div>
                        
                    </div>
    
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">transporteurs</h2>
                            </div>
                            <div class="p-5">
                                <table class="w-full p-5 text-gray-700">
                                    <thead>
                                        <tr>
                                            <th class="text-left text-blue-500">ID</th>
                                            <th class="text-left text-blue-500">Nom</th>
                                            <th class="text-left text-blue-500">Prix</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="carrier in carriers.slice(0, 10)">
                                            <td class="text-left">{{ carrier.id }}</td>
                                            <td class="text-left">{{ carrier.label }}</td>
                                            <td class="text-left">{{ carrier.fees }} €</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="py-2"><a href="#">Voir plus...</a></p>
                            </div>
                        </div>
                        
                    </div>
    
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h5 class="font-bold uppercase text-gray-600">users</h5>
                            </div>
                            <div class="p-5">
                                <table class="w-full p-5 text-gray-700">
                                    <thead>
                                    <tr>
                                        <th class="text-left text-blue-900">Email</th>
                                        <th class="text-left text-blue-900">Nom</th>
                                        <th class="text-left text-blue-900">Prénom</th>
                                    </tr>
                                    </thead>
    
                                    <tbody>
                                    <tr v-for="user in users.slice(0, 10)">
                                        <td class="text-left">{{ user.email }}</td>
                                        <td class="text-left">{{ user.lastname }}</td>
                                        <td class="text-left">{{ user.firstname }}</td>
                                    </tr>
                                    </tbody>
                                </table>
    
                                <p class="py-2"><a href="#">Voir plus...</a></p>
                     
                            </div>
                        </div>
                        
                    </div>
    
                        <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                            
                            <div class="bg-white border-transparent rounded-lg shadow-xl">
                                <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                    <h2 class="font-bold uppercase text-gray-600">sellers</h2>
                                </div>
                                <div class="p-5">
                                    <table class="w-full p-5 text-gray-700">
                                        <thead>
                                        <tr>
                                            <th class="text-left text-blue-900">Email</th>
                                            <th class="text-left text-blue-900">ShopLabel</th>
                                            <th class="text-left text-blue-900">Description</th>
                                            <th class="text-left text-blue-900">Prénom</th>
                                            <th class="text-left text-blue-900">Nom</th>
                                        </tr>
                                        </thead>
    
                                        <tbody>
                                        <tr v-for="seller in sellers.slice(0, 10)">
                                            <td class="text-left">{{ seller.shopEmailContact.substring(0, 15) }}...</td>
                                            <td class="text-left">{{ seller.shopLabel }}</td>
                                            <td class="text-left">{{ seller.shopDescription.substring(0, 10) }}...</td>
                                            <td class="text-left">{{ seller.firstname }}</td>
                                            <td class="text-left">{{ seller.lastname }}</td>
                                        </tr>
                         
                                        </tbody>
                                    </table>
    
                                    <p class="py-2"><a href="#">Voir plus...</a></p>
    
                                </div>
                            </div>
                            
                        </div>
    
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h2 class="font-bold uppercase text-gray-600">Demande revendeurs</h2>
                            </div>
                            <div class="p-5 ">
                                <table class="w-full p-5 text-gray-700">
                                    <thead>
                                        <tr>
                                            <th class="text-left text-blue-500">Email</th>
                                            <th class="text-left text-blue-500">Label</th>
                                            <th class="text-left text-blue-500">Description</th>
                                            <th class="text-left text-blue-500">Nom</th>
                                            <th class="text-left text-blue-500">Prénom</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="sellerRequest in requests.slice(0, 10)">
                                            <td class="text-left">{{ sellerRequest.shopEmailContact.substring(0, 15) }}...</td>
                                            <td class="text-left">{{ sellerRequest.shopLabel }}</td>
                                            <td class="text-left">{{ sellerRequest.shopDescription.substring(0, 10) }}...</td>
                                            <td class="text-left">{{ sellerRequest.lastname }}</td>
                                            <td class="text-left">{{ sellerRequest.firstname }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="py-2"><a href="#">Voir plus...</a></p>
                            </div>
                        </div>
                        
                    </div>
    
    
                    </div>
                </div>
            </section>
        </div>
    </main>

</template>
