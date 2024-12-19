<template>
    <component
        :is="productListComponent"
        :products="products"
        title="Favorite Products"
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

const products = ref<Product[]>(useFavoriteStore().items);
</script>
