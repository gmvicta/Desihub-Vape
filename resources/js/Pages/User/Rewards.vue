<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import UserLayouts from './Layouts/UserLayouts.vue';
import RedeemItemCard from '../User/Components/RedeemItem.vue';
import Footer from './Layouts/Footer.vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';

// Initialize Flowbite when component is mounted
onMounted(() => {
    initFlowbite();
});

const page = usePage();
const rewards = page.props.rewards;
const userPoints = page.props.userPoints;

// Filter states
const searchQuery = ref('');
const selectedCategory = ref('all');
const selectedBrand = ref('all');
const minPoints = ref(0);
const maxPoints = ref(10000);
const sortBy = ref('points-asc');

// Get unique categories and brands from rewards
const categories = computed(() => {
    const uniqueCategories = new Set(rewards.map(reward => reward.category));
    return ['all', ...Array.from(uniqueCategories)];
});

const brands = computed(() => {
    const uniqueBrands = new Set(rewards.map(reward => reward.brand));
    return ['all', ...Array.from(uniqueBrands)];
});

// Filtered rewards
const filteredRewards = computed(() => {
    return rewards.filter(reward => {
        // Search query filter
        const matchesSearch = searchQuery.value === '' ||
            reward.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            reward.description.toLowerCase().includes(searchQuery.value.toLowerCase());

        // Category filter
        const matchesCategory = selectedCategory.value === 'all' ||
            reward.category === selectedCategory.value;

        // Brand filter
        const matchesBrand = selectedBrand.value === 'all' ||
            reward.brand === selectedBrand.value;

        // Points range filter
        const matchesPoints = reward.points_required >= minPoints.value &&
            reward.points_required <= maxPoints.value;

        return matchesSearch && matchesCategory && matchesBrand && matchesPoints;
    }).sort((a, b) => {
        // Sorting
        switch (sortBy.value) {
            case 'points-asc':
                return a.points_required - b.points_required;
            case 'points-desc':
                return b.points_required - a.points_required;
            case 'name-asc':
                return a.title.localeCompare(b.title);
            case 'name-desc':
                return b.title.localeCompare(a.title);
            default:
                return 0;
        }
    });
});

// Reset filters
const resetFilters = () => {
    searchQuery.value = '';
    selectedCategory.value = 'all';
    selectedBrand.value = 'all';
    minPoints.value = 0;
    maxPoints.value = 10000;
    sortBy.value = 'points-asc';
};

// Toggle filter panel on mobile
const showFilters = ref(false);
const toggleFilters = () => {
    showFilters.value = !showFilters.value;
};
</script>

<template>
    <UserLayouts>
        <div class="container mx-auto px-4">
            <div class="p-6">
                <!-- Header with points display -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4 md:mb-0">
                        Redeem Vape Rewards
                    </h1>

                    <div class="flex items-center">
                        <div
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg">
                            Your Points:
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 ml-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                                {{ userPoints }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Mobile filter toggle -->
                <button @click="toggleFilters" type="button"
                    class="md:hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-4 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ showFilters ? 'Hide Filters' : 'Show Filters' }}
                    </span>
                </button>

                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Filter sidebar -->
                    <div :class="[
                        'transition-all duration-300 ease-in-out',
                        'md:w-1/4 md:block',
                        showFilters ? 'block' : 'hidden'
                    ]">
                        <div
                            class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                            <!-- Search input -->
                            <div class="mb-4">
                                <label for="search"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input v-model="searchQuery" type="search" id="search"
                                        class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Search rewards...">
                                </div>
                            </div>

                            <!-- Category filter -->
                            <div class="mb-4">
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select v-model="selectedCategory" id="category"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="category in categories" :key="category" :value="category">
                                        {{ category === 'all' ? 'All Categories' : category }}
                                    </option>
                                </select>
                            </div>

                            <!-- Brand filter -->
                            <div class="mb-4">
                                <label for="brand"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                                <select v-model="selectedBrand" id="brand"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="brand in brands" :key="brand" :value="brand">
                                        {{ brand === 'all' ? 'All Brands' : brand }}
                                    </option>
                                </select>
                            </div>

                            <!-- Points range filter -->
                            <div class="mb-4">
                                <label for="points-range"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Points
                                    Range</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label for="min-points"
                                            class="block mb-1 text-xs text-gray-500 dark:text-gray-400">Min</label>
                                        <input v-model.number="minPoints" type="number" id="min-points" min="0"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="max-points"
                                            class="block mb-1 text-xs text-gray-500 dark:text-gray-400">Max</label>
                                        <input v-model.number="maxPoints" type="number" id="max-points" min="0"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Sort options -->
                            <div class="mb-4">
                                <label for="sort"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sort By</label>
                                <select v-model="sortBy" id="sort"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="points-asc">Points: Low to High</option>
                                    <option value="points-desc">Points: High to Low</option>
                                    <option value="name-asc">Name: A to Z</option>
                                    <option value="name-desc">Name: Z to A</option>
                                </select>
                            </div>

                            <!-- Reset button -->
                            <button @click="resetFilters" type="button"
                                class="w-full text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                Reset Filters
                            </button>
                        </div>
                    </div>

                    <!-- Rewards grid -->
                    <div class="flex-1">
                        <!-- No results message -->
                        <div v-if="filteredRewards.length === 0"
                            class="flex flex-col items-center justify-center p-8 text-center bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">No rewards
                                match your filters</h5>
                            <p class="mb-5 text-base text-gray-500 dark:text-gray-400">Try adjusting your filter
                                criteria or search terms.</p>
                            <button @click="resetFilters" type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Reset All Filters
                            </button>
                        </div>

                        <!-- Results grid -->
                        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <RedeemItemCard v-for="reward in filteredRewards" :key="reward.id" :reward="reward"
                                :userPoints="userPoints" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayouts>
</template>