<template>
    <component
        :is="productListComponent"
        :products="products"
        title="Our Best Products"
        :loading="productsLoading"
    />

    <hr class="my-10" />

    <div
        class="font-[sans-serif] py-4 mx-auto lg:max-w-6xl max-w-lg md:max-w-full"
    >
        <h2 class="mb-6 text-4xl font-extrabold text-gray-800">New Arrivals</h2>
        <p class="text-2xl font-bold text-center text-gray-800">
            Coming soon...
        </p>
    </div>

    <hr class="my-10" />

    <div
        class="font-[sans-serif] py-4 mx-auto lg:max-w-6xl max-w-lg md:max-w-full"
    >
        <h2 class="mb-6 text-4xl font-extrabold text-gray-800">Latest News</h2>
        <p class="text-2xl font-bold text-center text-gray-800">
            Coming soon...
        </p>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';

const pageStore = usePageConfigurationStore();

const product_list = ref(pageStore.product_list);
const productListComponent = defineAsyncComponent({
    loader: () => import(`@/components/product-list/${product_list.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/product-list/default.vue`),
    timeout: 3000,
});

const apiUrl: string = useRuntimeConfig().public.apiUrl;

const products = ref<Product[]>([]);
const productsLoading = ref(true);
onMounted(async () => {
    const { data } = await $fetch<{ data: Product[] }>(
        `${apiUrl}/v1/products`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
        }
    );

    products.value = data;
    productsLoading.value = false;
});
</script>
