<script setup>
import { ref, computed, defineProps } from "vue";

const props = defineProps({
  columns: {
    type: Array,
    required: true,
  },
  data: {
    type: Array,
    required: true,
  },
  isEditing: {
    type: Boolean,
    required: false,
  },
  editForm: {
    type: Object,
    required: false,
  },
  cantEditing: {
    type: Boolean,
    required: false,
  },
});
</script>

<template>
  <main>
    <div>
      <section>
        <div
          style="margin-top: 37px"
          id="main"
          class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5"
        >
          <div class="overflow-x-auto p-5">
           
            <div
              class="min-w-screen min-h-screen bg-gray-100 flex-row items-center justify-center bg-gray-100 font-sans overflow-hidden"
            >
            <div>

                <button @click="$emit('onEdit', !props.isEditing)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ajouter
                </button>
            </div>
              <div class="w-full lg:w-5/6">
                <div class="bg-white shadow-md rounded my-6">
                  <table class="min-w-max w-full table-auto">
                    <thead>
                      <tr
                        class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal"
                      >
                        <th
                          v-for="column in props.columns"
                          class="py-3 px-6 text-left"
                        >
                          {{ column }}
                        </th>
                        <th class="py-3 px-6 text-left"></th>
                      </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                      <tr
                        v-for="(row, index) in props.data"
                        class="border-b border-gray-200 hover:bg-gray-100"
                      >
                        <td
                          v-for="(value, index) in row"
                          class="py-3 px-6 text-left whitespace-nowrap"
                        >
                          <div class="flex items-center">
                            <template
                              v-if="
                                typeof value === 'string' && value.length > 190
                              "
                            >
                              <span>{{ value.slice(0, 190) + "..." }}</span>
                            </template>
                            <template
                            
                              v-if="
                                typeof value === 'number' &&
                                index === 'price' ||
                                index === 'total' 
                              "
                            >
                              <span>{{ value }} €</span>
                            </template>
                            <template v-else class="mr-2">
                              <span>{{ value }}</span>
                            </template>
                          </div>
                        </td>
                        
                        <td v-if="props.cantEditing !== true" class="py-3 px-6 text-center">
                          <div class="flex item-center justify-center">
                            <div
                              class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                            >
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                @click="$emit('editForm', props.data)"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                />
                              </svg>
                            </div>
                            <div
                              class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                            >
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                />
                              </svg>
                            </div>
                          </div>
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
    </div>
  </main>
</template>
