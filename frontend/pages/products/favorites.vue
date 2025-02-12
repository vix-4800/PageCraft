<template>
    <div>
        <page-title title="Your Favorites" />

        <editable-block :name="TemplateBlock.ProductList">
            <component
                :is="productListComponent"
                :products="products"
                title="Favorite Products"
            />
        </editable-block>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';
import { TemplateBlock } from '~/types/template';

const templateStore = useSiteTemplatesStore();

const productListComponent = computed(() => {
    const template = templateStore.getTemplate(TemplateBlock.ProductList);

    return defineAsyncComponent({
        loader: () => import(`@/components/product-list/${template}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/product-list/default.vue`),
        timeout: 3000,
    });
});

const products = ref<Product[]>([]);
onMounted(async () => {
    await fetchProducts();
});

const favoriteStore = useFavoriteStore();

watch(favoriteStore.items, () => {
    fetchProducts();
});

async function fetchProducts() {
    if (favoriteStore.totalItemsCount === 0) {
        products.value = [];
        return;
    }

    const { data } = await apiFetch<{ data: Product[] }>(`v1/products`, {
        params: {
            slugs: favoriteStore.items.join(','),
        },
    });

    products.value = data;
}
</script>
