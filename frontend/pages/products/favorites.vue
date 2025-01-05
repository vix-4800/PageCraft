<template>
    <component
        :is="productListComponent"
        :products="products"
        title="Favorite Products"
    />
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const productList = ref(templateStore.getTemplate(TemplateBlock.ProductList));
const productListComponent = defineAsyncComponent({
    loader: () => import(`@/components/product-list/${productList.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/product-list/default.vue`),
    timeout: 3000,
});

const products = ref<Product[]>([]);
onMounted(async () => {
    await fetchProducts();
});

watch(useFavoriteStore().items, () => {
    fetchProducts();
});

async function fetchProducts() {
    const { data } = await apiFetch<{ data: Product[] }>(`v1/products`, {
        params: {
            slugs: useFavoriteStore().items.join(','),
        },
    });

    products.value = data;
}
</script>
