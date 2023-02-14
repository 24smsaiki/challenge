<script setup>
import { ref, computed, onMounted, reactive } from "vue";
import OrdersLogic from "../../logics/OrdersLogic";
import CarriersLogic from "../../logics/CarriersLogic";
import ProductsLogic from "../../logics/ProductsLogic";
import UsersLogic from "../../logics/UsersLogic";
import ReturnLogic from "../../logics/ReturnLogic";
import moment from "moment";
import Header from "../../components/Admin/Header.vue";
import router from "../../router/Router";

const orders = ref([]);
const carriers = ref([]);
const products = ref([]);
const users = ref([]);
const sellers = ref([]);
const requests = ref([]);
const requestsReturn = ref([]);

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

const fetchReturn = async () => {
  return await ReturnLogic.getReturns().then((response) => {
    requestsReturn.value = response.data;
  });
};

const declineRequestSeller = async (id) => {
  return await UsersLogic.declineRequestSellers(id).then(() => {
	fetchRequests();
  });
};

const acceptRequestSeller = async (id) => {
  return await UsersLogic.acceptRequestSellers(id).then(() => {
	fetchRequests();
  });
};

const onAcceptSeller = async (id) => {
 await acceptRequestSeller(id).then(() => {
	requests.value.filter((request) => request.id !== id);
	sellers.value.push(requests.value.find((request) => request.id === id));
  });
};

const onDeclineSeller = async (id) => {
 await declineRequestSeller(id).then(() => {
	requests.value.filter((request) => request.id !== id);
  });
};

const onAcceptReturn = async (id) => {
	const body = {
		state: 2,
		idReturn: id,
		customerEmail: requestsReturn.value.find((request) => request.id === id).customerEmail,
	}
  return await ReturnLogic.updateReturn(body).then(() => {
	requestsReturn.value.filter((request) => request.id !== id);
  });
};

const DeliveryOrder = async (id) => {
  const body = {
    state: 5
  }
  return await OrdersLogic.updateOrder(id, body).then(() => {

  orders.value.map((order) => {
    if (order.id === id) {
      order.state = 5;
    }
  });
  });
};

onMounted(() => {
  fetchOrders();
  fetchCarriers();
  fetchProducts();
  fetchUsers();
  fetchSellers();
  fetchRequests();
  fetchReturn();
});
</script>

<template>
  <!-- header -->
<Header />

  <section class="dashboard">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
      <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
          <div class="bg-white border rounded shadow p-2">
            <div class="flex flex-row items-center">
              <div class="flex-shrink pr-4">
                <div class="rounded p-3 bg-green-600">
                  <i class="fa fa-google-wallet"></i>
                </div>
              </div>
              <div class="flex-1 text-right md:text-center">
                <h5 class="font-bold uppercase color-orange">
                  Nombre de commandes
                </h5>
                <h3 class="font-bold text-3xl">
                  {{ orders ? orders.length : null }}
                  <span class="text-green-500"
                    ><i class="fa fa-caret-up"></i
                  ></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
          <div class="bg-white border rounded shadow p-2">
            <div class="flex flex-row items-center">
              <div class="flex-shrink pr-4">
                <div class="rounded p-3 bg-pink-600">
                  <i class="fa fa-users"></i>
                </div>
              </div>
              <div class="flex-1 text-right md:text-center">
                <h5 class="font-bold uppercase color-orange">
                  Nombre de transporteurs
                </h5>
                <h3 class="font-bold text-3xl">
                  {{ carriers ? carriers.length : null }}
                  <span class="text-pink-500"
                    ><i class="fa fa-exchange-alt"></i
                  ></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
          <div class="bg-white border rounded shadow p-2">
            <div class="flex flex-row items-center">
              <div class="flex-shrink pr-4">
                <div class="rounded p-3 bg-yellow-600">
                  <i class="fa fa-user-plus"></i>
                </div>
              </div>
              <div class="flex-1 text-right md:text-center">
                <h5 class="font-bold uppercase color-orange">
                  Nombre de Produits
                </h5>
                <h3 class="font-bold text-3xl">
                  {{ products ? products.length : null }}
                  <span class="text-yellow-600"
                    ><i class="fa fa-caret-up"></i
                  ></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
          <div class="bg-white border rounded shadow p-2">
            <div class="flex flex-row items-center">
              <div class="flex-shrink pr-4">
                <div class="rounded p-3 bg-blue-600">
                  <i class="fas fa-user"></i>
                </div>
              </div>
              <div class="flex-1 text-right md:text-center">
                <h5 class="font-bold uppercase color-orange">
                  Nombre d'utilisateurs
                </h5>
                <h3 class="font-bold text-3xl">
                  {{ users ? users.length : null }}
                  <span class="text-blue-500"
                    ><i class="fa fa-caret-up"></i
                  ></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
		<div class="w-full md:w-1/2 xl:w-1/3 p-3">
          <div class="bg-white border rounded shadow p-2">
            <div class="flex flex-row items-center">
              <div class="flex-shrink pr-4">
                <div class="rounded p-3 bg-purple-600">
                  <i class="fas fa-user"></i>
                </div>
              </div>
              <div class="flex-1 text-right md:text-center">
                <h5 class="font-bold uppercase color-orange">
                  Demande de vendeurs
                </h5>
                <h3 class="font-bold text-3xl">
                  {{ requests ? requests.length : null }}
                  <span class="text-purple-500"
                    ><i class="fa fa-caret-up"></i
                  ></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/2 xl:w-1/3 p-3">
          <div class="bg-white border rounded shadow p-2">
            <div class="flex flex-row items-center">
              <div class="flex-shrink pr-4">
                <div class="rounded p-3 bg-purple-600">
                  <i class="fas fa-user"></i>
                </div>
              </div>
              <div class="flex-1 text-right md:text-center">
                <h5 class="font-bold uppercase color-orange">
                  Demande de retour
                </h5>
                <h3 class="font-bold text-3xl">
                  {{ requestsReturn ? requestsReturn.length : null }}
                  <span class="text-purple-500"
                    ><i class="fa fa-caret-up"></i
                  ></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
		
		<div class="w-full md:w-1/2 xl:w-1/3 p-3">
          <div class="bg-white border rounded shadow p-2">
            <div class="flex flex-row items-center">
              <div class="flex-shrink pr-4">
                <div class="rounded p-3 bg-red-600">
                  <i class="fas fa-user"></i>
                </div>
              </div>
              <div class="flex-1 text-right md:text-center">
                <h5 class="font-bold uppercase color-orange">
                  Nombre de vendeurs
                </h5>
                <h3 class="font-bold text-3xl">
                  {{ sellers ? sellers.length : null }}
                  <span class="text-red-500"
                    ><i class="fa fa-caret-up"></i
                  ></span>
                </h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr class="border-b-2 border-gray-400 my-8 mx-4" />
      <div class="flex flex-row flex-wrap flex-grow mt-2">
        <div class="w-full md:w-1/3 p-3">
          <div class="bg-white border rounded shadow">
            <div class="border-b p-3">
              <h5 class="font-bold uppercase color-orange">Utilisateurs</h5>
            </div>
            <div class="p-5">
              <table class="w-full p-5 text-gray-700">
                <thead>
                  <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Adresse mail</th>
                    <th class="text-left">Nom</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, index) in users" :key="user.id">
                    <td class="pt-2">{{ index === 0 ? 1 : index + 1 }}</td>
                    <td class="pt-2">{{ user.email }}</td>
                    <td class="pt-2">
                      {{ user.firstname + " " + user.lastname }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/3 p-3">
          <!-- <RoomCard
						v-if="isEditing"
						:room="current_room"
						:addRoom="fetchAddRoom"
						:changeIsEditing="changeIsEditing"
						:editRoom="fetchUpdateRoom"
					/> -->
          <div class="bg-white border rounded shadow">
            <div class="border-b p-3 flex justify-between">
              <div>
                <h5 class="font-bold uppercase color-orange">Vendeurs</h5>
              </div>
              <!-- <div>
                <font-awesome-icon icon="circle-plus" style="cursor: pointer" />
              </div> -->
            </div>
            <div class="p-5">
              <table class="w-full p-5 text-gray-700">
                <thead>
                  <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Email</th>
                    <th class="text-left">Label</th>
                    <th class="text-left">Description</th>
                    <th class="text-left">Téléphone</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="seller in sellers" :key="seller.id">
                    <td class="pt-2">{{ seller.id }}</td>
                    <td class="pt-2">{{ seller.shopEmailContact }}</td>
                    <td class="pt-2">{{ seller.shopLabel }}</td>
                    <td class="pt-2">
                      {{ seller.shopDescription.slice(0, 15) }}
                    </td>
                    <td class="pt-2">{{ seller.shopPhoneContact }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/3 p-3">
          <div class="bg-white border rounded shadow">
            <div class="border-b p-3 flex justify-between">
              <div>
                <h5 class="font-bold uppercase color-orange">Produits</h5>
              </div>
            </div>
            <div class="p-5">
              <table class="w-full p-5 text-gray-700">
                <thead>
                  <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Label</th>
                    <th class="text-left">Description</th>
                    <th class="text-left">Prix</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="product in products.slice(0, 11)"
                    :key="product.id"
                  >
                    <td class="pt-2">{{ product.id }}</td>
                    <td class="pt-2">{{ product.label }}</td>
                    <td class="pt-2">
                      {{ product.description.slice(0, 40) }}...
                    </td>
                    <td class="pt-2">{{ product.price }} €</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/3 p-3">
          <div class="bg-white border rounded shadow">
            <div class="border-b p-3 flex justify-between">
              <div>
                <h5 class="font-bold uppercase color-orange">Commandes</h5>
              </div>
            </div>
            <div class="p-5">
              <table class="w-full p-5 text-gray-700">
                <thead>
                  <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Référence</th>
                    <th class="text-left">Date</th>
                    <th class="text-left">Montant</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="order in orders.slice(0, 10)" :key="order.id">
                    <td class="pt-2">{{ order.id }}</td>
                    <td class="pt-2">{{ order.reference }}</td>
                    <td class="pt-2">
                      {{ moment(order.createdAt).format("DD/MM/YYYY") }}
                    </td>
                    <td class="pt-2">{{ order.total }} €</td>
                    <td @click="DeliveryOrder(order.id)" class="pt-2" >
                      <button v-if="order.state !== 5" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                        Livrer la commande
                      </button>
                      <span v-else class="bg-green-500 text-white font-bold py-2 px-4 rounded">
                        Commande livrée
                      </span>
                    </td>
                  </tr>
                  
                </tbody>
              </table>
            
            </div>
            <!-- Voir toutes les commandes -->
            <div class="p-5">
              <router-link to="/admin/orders" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Voir toutes les commandes
              </router-link>
            </div>
          </div>
          
        </div>
        <div class="w-full md:w-1/3 p-3">
          <div class="bg-white border rounded shadow">
            <div class="border-b p-3 flex justify-between">
              <div>
                <h5 class="font-bold uppercase color-orange">
                  Demandes vendeur
                </h5>
              </div>
            </div>
            <div class="p-5">
              <table class="w-full p-5 text-gray-700">
                <thead>
                  <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Email</th>
                    <th class="text-left">Label</th>
                    <th class="text-left">Description</th>
                    <th class="text-left">Téléphone</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="seller in requests" :key="seller.id">
                    <td class="pt-2">{{ seller.id }}</td>
                    <td class="pt-2">
                      {{ seller.shopEmailContact.slice(0, 16) }}...
                    </td>
                    <td class="pt-2">{{ seller.shopLabel }}</td>
                    <td class="pt-2">
                      {{ seller.shopDescription.slice(0, 15) }}
                    </td>
                    <td class="pt-2">{{ seller.shopPhoneContact }}</td>
                    <td class="pt-2">
                      <font-awesome-icon
                        icon="check"
                        style="color: blue; cursor: pointer"
						@click="onAcceptSeller(seller.id)"
                      />
                      <font-awesome-icon
                        icon="xmark"
                        style="
                          color: #d71a1a;
                          margin-left: 5px;
                          cursor: pointer;
                        "
						@click="onDeclineSeller(seller.id)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/3 p-3">
          <div class="bg-white border rounded shadow">
            <div class="border-b p-3 flex justify-between">
              <div>
                <h5 class="font-bold uppercase color-orange">
                  Demande de retour
                </h5>
              </div>
            </div>
            <div class="p-5">
              <table class="w-full p-5 text-gray-700">
                <thead>
                  <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Nom</th>
                    <th class="text-left">Email</th>
                    <th class="text-left">Téléphone</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="request in requestsReturn">
                    <td class="pt-2">{{ request.id }}</td>
                    <td class="pt-2">{{ request.name }}</td>
                    <td class="pt-2">{{ request.email }}</td>
                    <td class="pt-2">{{ request.phone }}</td>
                    <td class="pt-2">
                      <font-awesome-icon
                        icon="check"
                        style="color: blue; cursor: pointer"
                      />
                      <font-awesome-icon
                        icon="xmark"
                        style="
                          color: #d71a1a;
                          margin-left: 5px;
                          cursor: pointer;
                        "
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.dashboard {
  margin: 40px 50px 20px 50px;
}

.dashboard .fa-google-wallet,
.dashboard .fa-users,
.dashboard .fa-user-plus {
  font-size: 30px;
  color: white;
}

.dashboard .toggle {
  cursor: pointer;
  display: inline-block;
}

.dashboard .toggle-switch {
  display: inline-block;
  background: #ccc;
  border-radius: 16px;
  width: 58px;
  height: 26px;
  position: relative;
  vertical-align: middle;
  transition: background 0.25s;
}

.dashboard .toggle-switch:before,
.dashboard .toggle-switch:after {
  content: "";
}

.dashboard .toggle-switch:before {
  display: block;
  background: linear-gradient(to bottom, #fff 0%, #eee 100%);
  border-radius: 50%;
  box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.25);
  width: 19px;
  height: 19px;
  position: absolute;
  top: 4px;
  left: 4px;
  transition: left 0.25s;
}

.dashboard .heading {
  padding-left: 7.5px;
}

@media (max-width: 767px) {
  .dashboard .heading {
    padding-left: 0;
    justify-content: center;
    margin-bottom: 12px;
  }

  .leading-normal {
    margin-bottom: 0;
  }
}

@media (max-width: 565px) {
  .dashboard {
    margin: 0;
  }
}

.dashboard .toggle:hover .toggle-switch:before {
  background: linear-gradient(to bottom, #fff 0%, #fff 100%);
  box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.5);
}

.dashboard .toggle-checkbox:checked + .toggle-switch {
  background: #f04c26;
}

.dashboard .toggle-checkbox:checked + .toggle-switch:before {
  left: 35px;
}

.pt-2 {
  padding-top: 10px;
}

.dashboard .color-orange {
  color: #f04c26;
}

.dashboard .toggle-checkbox {
  position: absolute;
  visibility: hidden;
}

.dashboard .toggle-label {
  margin-right: 5px;
  position: relative;
  top: 2px;
}
</style>
