<script setup>
import Header from "../../components/Admin/Header.vue";
import Table from "../../components/Admin/Table.vue";
import OrdersLogic from "../../logics/OrdersLogic";
import { ref, reactive } from "vue";
import CarriersLogic from "../../logics/CarriersLogic";
import moment from "moment";

const orders = ref([]);
let columns = ref([]);
const carriers = ref([]);
const isEditing = ref(false);

const errors = reactive({
  id: "",
  reference: "",
  total: "",
  isPaid: "",
  createdAt: "",
  carrier: "",
});

const form = ref({
  id: null,
  reference: "",
  total: "",
  isPaid: "",
  createdAt: "",
  carrier: "",
});

const isFormValid = () => {
  if (
    form.value.reference !== "" &&
    form.value.total !== "" &&
    form.value.isPaid !== "" &&
    form.value.createdAt !== "" &&
    form.value.carrier !== ""
  ) {
    return true;
  } else {
    return false;
  }
};

const isReference = () => {
  const reference = form.value.reference;
  if (reference.length < 3) {
    errors.reference = "La référence doit contenir au moins 3 caractères.";
  } else {
    errors.reference = "";
  }
};

const isTotal = () => {
  const total = form.value.total;
  if (total.length < 3) {
    errors.total = "Le total doit contenir au moins 3 caractères.";
  } else {
    errors.total = "";
  }
};

const isIsPaid = () => {
  const isPaid = form.value.isPaid;
  if (isPaid.length < 3) {
    errors.isPaid =
      "Le statut de paiement doit contenir au moins 3 caractères.";
  } else {
    errors.isPaid = "";
  }
};

const isCreatedAt = () => {
  const createdAt = form.value.createdAt;
  if (createdAt.length < 3) {
    errors.createdAt = "La date doit contenir au moins 3 caractères.";
  } else {
    errors.createdAt = "";
  }
};

const isCarrier = () => {
  const carrier = form.value.carrier;
  if (carrier.length < 3) {
    errors.carrier = "Le transporteur doit contenir au moins 3 caractères.";
  } else {
    errors.carrier = "";
  }
};

const onEdit = (data) => {
  isEditing.value = data;
};

const resetForm = () => {
  form.value.id = null;
  form.value.reference = "";
  form.value.total = "";
  form.value.isPaid = "";
  form.value.createdAt = "";
  form.value.carrier = "";
  isEditing.value = false;
};

const editForm = (data) => {
  form.value.id = data.id;
  form.value.reference = data.reference;
  form.value.total = data.total;
  form.value.isPaid = data.isPaid;
  form.value.createdAt = data.createdAt;
  form.value.carrier = data.carrier;
  isEditing.value = true;
};

const onSubmit = () => {
  if (isFormValid()) {
    if (form.value.id) {
      OrdersLogic.updateOrder(form.value.id, form.value).then((response) => {
        if (response.status === 200) {
          resetForm();
          orders.value = orders.value.map((order) => {
            if (order.id === response.data.id) {
              return response.data;
            } else {
              return order;
            }
          });
        }
      });
    } else {
      OrdersLogic.createOrder(form.value).then((response) => {
        if (response.status === 201) {
          resetForm();
          orders.value.push(response.data);
        }
      });
    }
  }
};

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
      createdAt: order.createdAt,
    };
  });

  // supprimer les propriétés orderDetails, customer, delivery
  response.data.forEach((order) => {
    delete order.orderDetails;
    delete order.customer;
    delete order.delivery;
  });
  orders.value = response.data;
  columns = Object.keys(orders.value[0]);
});

getCarriers();
</script>

<template class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">
  <Header />
  <Table
    :cantEditing="true"
    :data="orders"
    :columns="columns"
    @onEdit="onEdit"
    :isEditing="isEditing"
    @editForm="editForm"
  />
</template>
