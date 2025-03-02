<script setup>
import userLayout from '../User/Layouts/UserLayouts.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import PurchaseDetailsModal from '../User/Components/ItemViewModal.vue';

// Mock data for purchases (replace with actual data from your backend)
const allPurchases = ref([
  {
    id: 1,
    product: 'Classic Vape Pen',
    price: 29.99,
    date: '2023-10-01',
    status: 'Completed',
    image: '/placeholder.svg?height=100&width=100', // Placeholder image
    orderNumber: 'ORD123456',
  },
  {
    id: 2,
    product: 'Fruit Medley E-Liquid',
    price: 14.99,
    date: '2023-10-05',
    status: 'Pending',
    image: '/placeholder.svg?height=100&width=100', // Placeholder image
    orderNumber: 'ORD123457',
  },
  {
    id: 3,
    product: 'Advanced Mod Kit',
    price: 79.99,
    date: '2023-10-10',
    status: 'To Receive',
    image: '/placeholder.svg?height=100&width=100', // Placeholder image
    orderNumber: 'ORD123458',
  },
  {
    id: 4,
    product: 'Replacement Coils',
    price: 9.99,
    date: '2023-10-15',
    status: 'Cancelled',
    image: '/placeholder.svg?height=100&width=100', // Placeholder image
    orderNumber: 'ORD123459',
  },
]);

const selectedFilter = ref('All');

const filteredPurchases = computed(() => {
  if (selectedFilter.value === 'All') {
    return allPurchases.value;
  }
  return allPurchases.value.filter(purchase => purchase.status === selectedFilter.value);
});

const selectedPurchase = ref(null);
const isModalOpen = ref(false);

const openModal = (purchase) => {
  selectedPurchase.value = purchase;
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  selectedPurchase.value = null;
};

// Function to format currency in PHP
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-PH', {
    style: 'currency',
    currency: 'PHP',
  }).format(amount);
};

const filterOptions = [
  { value: 'All', label: 'All' },
  { value: 'Pending', label: 'Pending' },
  { value: 'To Receive', label: 'To Receive' },
  { value: 'Completed', label: 'Completed' },
  { value: 'Cancelled', label: 'Cancelled' },
];
</script>

<template>
  <Head title="My Purchases" />

  <userLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Purchases</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <!-- Filter Tabs with Animation -->
            <div class="flex space-x-4 mb-6 border-b relative">
              <button
                v-for="option in filterOptions"
                :key="option.value"
                @click="selectedFilter = option.value"
                class="py-2 px-4 text-sm font-medium transition-colors duration-300 ease-in-out relative"
                :class="[
                  selectedFilter === option.value
                    ? 'text-blue-600'
                    : 'text-gray-500 hover:text-gray-700'
                ]"
              >
                {{ option.label }}
                <transition name="slide">
                  <span
                    v-if="selectedFilter === option.value"
                    class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600"
                  ></span>
                </transition>
              </button>
            </div>

            <div v-if="filteredPurchases.length === 0" class="text-gray-500">
              No purchases found for the selected filter.
            </div>
            <div v-else>
              <div class="space-y-4">
                <div v-for="purchase in filteredPurchases" :key="purchase.id" class="border p-4 rounded-lg shadow">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <img :src="purchase.image" alt="Product Image" class="w-24 h-24 object-cover rounded" />
                      <div class="ml-4">
                        <h3 class="font-semibold text-lg">{{ purchase.product }}</h3>
                        <p class="text-gray-600">Order Number: {{ purchase.orderNumber }}</p>
                        <p class="text-gray-600">Price: {{ formatCurrency(purchase.price) }}</p>
                        <p class="text-gray-600">Date: {{ purchase.date }}</p>
                        <p class="text-gray-600">Status: 
                          <span :class="{
                            'text-green-500': purchase.status === 'Completed',
                            'text-yellow-500': purchase.status === 'Pending',
                            'text-blue-500': purchase.status === 'To Receive',
                            'text-red-500': purchase.status === 'Cancelled'
                          }">
                            {{ purchase.status }}
                          </span>
                        </p>
                      </div>
                    </div>
                    <button @click="openModal(purchase)" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                      View Details
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Purchase Details -->
    <PurchaseDetailsModal
      v-if="isModalOpen && selectedPurchase"
      :purchase="selectedPurchase"
      :isOpen="isModalOpen"
      @close="closeModal"
    />
  </userLayout>
</template>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}
.slide-enter-from,
.slide-leave-to {
  transform: translateX(10px);
  opacity: 0;
}
</style>