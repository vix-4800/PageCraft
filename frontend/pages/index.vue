<template>
    <component
        :is="productListComponent"
        :products="products"
        title="Our Products"
    />
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
});
</script>
