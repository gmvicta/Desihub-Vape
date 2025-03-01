<template>
    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="product in products" :key="product.id" class="group relative">
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none lg:h-80">
                <img v-if="product.product_images.length > 0" :src="`/${product.product_images[0].image}`"
                    :alt="product.imageAlt"
                    class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                <img v-else
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png"
                    :alt="product.imageAlt"
                    class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
            </div>
            <div class="mt-4 flex justify-between">
                <div>
                    <h3 class="text-sm text-gray-700">
                        <span aria-hidden="true" class="" />
                        {{ product.title }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">{{ product.brand.name }}</p>
                </div>
                <p class="text-sm font-medium text-gray-900">₱{{ product.price }}</p>
            </div>
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer">
                <button @click="redeemProduct(product)" class="bg-blue-700 p-2 rounded-full">
                    <span class="text-white">Redeem</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    products: Array,
});

const redeemProduct = (product) => {
    // Here you can implement the redeem logic
    router.post(route('loyalty.points.redemption.redeem'), { product_id: product.id }, {
        onSuccess: (page) => {
            if (page.props.flash.success) {
                Swal.fire({
                    toast: true,
                    icon: "success",
                    position: "top-end",
                    showConfirmButton: false,
                    title: page.props.flash.success,
                });
            } else if (page.props.flash.error) {
                Swal.fire({
                    toast: true,
                    icon: "error",
                    position: "top-end",
                    showConfirmButton: false,
                    title: page.props.flash.error,
                });
            }
        },
    });
};
</script>

<style scoped>
/* Add any additional styles here */
</style>