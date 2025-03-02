<template>
    <Transition name="modal">
      <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full modal-content">
          <h3 class="font-semibold text-lg">{{ purchase.product }}</h3>
          <img :src="purchase.image" alt="Product Image" class="w-full h-48 object-cover rounded mt-2" />
          <p class="text-gray-600">Order Number: {{ purchase.orderNumber }}</p>
          <p class="text-gray-600">Price: ${{ purchase.price.toFixed(2) }}</p>
          <p class="text-gray-600">Date: {{ purchase.date }}</p>
          <p class="text-gray-600">Status: <span :class="{'text-green-500': purchase.status === 'Delivered', 'text-yellow-500': purchase.status === 'Pending'}">{{ purchase.status }}</span></p>
          <p class="mt-2">{{ purchase.description }}</p>
          <button @click="closeModal" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
            Close
          </button>
        </div>
      </div>
    </Transition>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const props = defineProps({
    purchase: {
      type: Object,
      required: true,
    },
    isOpen: {
      type: Boolean,
      required: true,
    },
  });
  
  const emit = defineEmits(['close']);
  
  const closeModal = () => {
    emit('close');
  };
  </script>
  
  <style scoped>
  .modal-enter-active,
  .modal-leave-active {
    transition: all 0.3s ease;
  }
  
  .modal-enter-from,
  .modal-leave-to {
    opacity: 0;
    transform: scale(0.9);
  }
  
  .modal-enter-to,
  .modal-leave-from {
    opacity: 1;
    transform: scale(1);
  }
  
  .modal-content {
    transition: all 0.3s ease;
    transform: scale(1);
  }
  
  .modal-enter-from .modal-content,
  .modal-leave-to .modal-content {
    transform: scale(0.9);
  }
  </style>