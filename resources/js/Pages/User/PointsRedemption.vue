<template>
    <User Layouts>
        <div class="bg-white">
            <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-24">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900">Loyalty Points Redemption</h1>
                </div>

                <section aria-labelledby="products-heading" class="pb-24 pt-6">
                    <h2 id ="products-heading" class="sr-only">Available Products</h2>
                    <ProductsRedeem :products="products" />
                </section>
            </main>
        </div>
    </User >
</template>

<script setup>
import ProductsRedeem from './ProductsRedeem.vue';
import { ref, onMounted } from 'vue';

const products = ref([]);

onMounted(async () => {
    const response = await fetch('/api/redeemable-products');
    products.value = await response.json();
});
</script>

<style scoped>
/* Add any additional styles here */
</style>