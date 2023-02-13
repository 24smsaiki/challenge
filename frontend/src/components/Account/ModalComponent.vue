<script setup>
import { ref, defineProps, computed } from "vue";

const props = defineProps({
  modalIsOpen: {
    type: Boolean,
    default: false,
  },
  modalTitle: {
    type: String,
    default: "",
  },
  modalContent: {
    type: String,
    default: "",
  },
  modalOrder: {
    type: Object,
  },
});

const modalIsOpen = ref(props.modalIsOpen);
const modalTitle = ref(props.modalTitle);
const modalContent = ref(props.modalContent);
const modalOrder = ref(props.modalOrder);
const reason = ref("");
const errors = ref({
  reason: "",
});

const isReason = () => {
  if (reason.value.length < 10) {
    errors.value.reason = "La raison doit contenir au moins 10 caractères";
  } else {
    errors.value.reason = "";
  }
};

const isFormValid = computed(() => {
  if (errors.value.reason === "" && reason.value !== "") {
    return true;
  } else {
    return false;
  }
});

const setValidModalClass = computed(() => {
  if (isFormValid.value === true) {
    return "";
  } else {
    return {
      cursor: "not-allowed",
      backgroundColor: "#e0e0e0",
    };
  }
});

defineEmits([
  "openModalStateChange",
  "cancelModalStateChange",
  "acceptModalStateChange",
]);
</script>

<template>
  <div v-if="modalIsOpen" id="modal">
    <div
      class="h-full w-full fixed top-0 left-0 z-20"
      @click="$emit('openModalStateChange')"
    ></div>
    <div
      class="bg-white rounded-lg text-lg pt-6 shadow-lg fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-30 modal-bloc"
    >
      <div class="px-6 pb-6 text-center">
        <h3 class="text-xl mb-2 font-semibold">{{ modalTitle }}</h3>
        <p class="text-gray-600 font-light">
          {{ modalContent }}
        </p>
      </div>
      <div class="px-6 pb-6 text-center">
        <input
          class="appearance-none border rounded w-full py-2 px-3 focus:outline-none"
          id="reason"
          type="text"
          placeholder="Raison du retour"
          v-model="reason"
          @input="isReason"
        />
        <p class="text-xs italic messageErrors mt-4" v-if="errors.reason">
          {{ errors.reason }}
        </p>
      </div>
      <div class="cursor-pointer border-t border-gray-100 text-center d-flex">
        <button
          @click="$emit('cancelModalStateChange')"
          class="btn mr-5 cancel"
        >
          Annuler
        </button>
        <button
          @click="$emit('acceptModalStateChange', modalOrder, reason)"
          class="btn accept"
          :disabled="!isFormValid"
          :style="setValidModalClass"
        >
          Accepter
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
#modal {
  .cancel {
    border-right: 1px solid #f3d8d8;
  }

  .messageErrors {
    color: red;
    font-size: 12px;
  }

  .modal-bloc {
    width: 400px;
  }

  .cancel,
  .accept {
    width: 50%;
    padding: 10px;
    cursor: pointer;
  }

  .btn {
    padding: 10px 20px;
    background-color: #808080;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;

    &:hover {
      background-color: #666666;
    }
  }
}

.d-flex {
  display: flex;
}
</style>
