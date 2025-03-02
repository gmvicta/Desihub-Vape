<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    reward: Object,
    userPoints: Number
});

const selectedReward = ref(null);

const openModal = () => {
    selectedReward.value = true;
};

const closeModal = () => {
    selectedReward.value = false;
};

const redeemReward = () => {
    router.post(`/redeem/${reward.id}`, {}, {
        onSuccess: () => {
            alert("Redemption successful!");
            closeModal();
        }
    });
};
</script>

<template>
    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-md">
        <img class="rounded-t-lg w-full h-40 object-cover" :src="reward.image" alt="Reward Image">
        <div class="p-5">
            <h5 class="text-lg font-bold tracking-tight text-gray-900">{{ reward.title }}</h5>
            <p class="text-gray-700 mt-2">{{ reward.description }}</p>
            <p class="mt-2 font-semibold">Points Required: <span class="text-blue-500">{{ reward.points_required }}</span></p>

            <button 
                @click="openModal"
                :disabled="userPoints < reward.points_required"
                class="mt-3 w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 disabled:bg-gray-400"
            >
                Redeem
            </button>
        </div>

        <!-- Modal for Confirmation -->
        <div v-if="selectedReward" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
                <h2 class="text-xl font-semibold text-gray-900">Confirm Redemption</h2>
                <p class="mt-2 text-gray-700">Are you sure you want to redeem <strong>{{ reward.title }}</strong> for <span class="text-blue-500">{{ reward.points_required }}</span> points?</p>

                <div class="flex justify-end mt-4 space-x-3">
                    <button @click="closeModal" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">Cancel</button>
                    <button @click="redeemReward" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</template>
