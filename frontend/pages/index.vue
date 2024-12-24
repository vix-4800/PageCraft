<template>
    <div>
        <component
            :is="productListComponent"
            :products="newProducts"
            title="New Arrivals"
            :loading="newProductsLoading"
        />

        <hr class="my-10" />

        <component
            :is="productListComponent"
            :products="popularProducts"
            title="Popular Products"
            :loading="popularProductsLoading"
        />

        <hr class="my-10" />

        <div
            class="font-[sans-serif] py-4 mx-auto lg:max-w-6xl max-w-lg md:max-w-full"
        >
            <h2 class="mb-6 text-4xl font-extrabold text-gray-800">
                Latest News
            </h2>
            <p class="text-2xl font-bold text-center text-gray-800">
                Coming soon...
            </p>
        </div>
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

const popularProducts = ref<Product[]>([]);
const popularProductsLoading = ref(true);

const newProducts = ref<Product[]>([]);
const newProductsLoading = ref(true);

onMounted(async () => {
    const { data: popularProductsData } = await apiFetch<{ data: Product[] }>(
        `v1/products/popular`,
        {
            params: {
                limit: product_list.value === 'compact' ? 4 : 6,
            },
        }
    );

    popularProducts.value = popularProductsData;
    popularProductsLoading.value = false;

    const { data: newProductsData } = await apiFetch<{ data: Product[] }>(
        `v1/products/new`,
        {
            params: {
                limit: product_list.value === 'compact' ? 4 : 6,
            },
        }
    );

    newProducts.value = newProductsData;
    newProductsLoading.value = false;
});
</script>
