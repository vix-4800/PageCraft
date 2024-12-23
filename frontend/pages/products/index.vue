<template>
    <div>
        <component
            :is="productListComponent"
            :products="products"
            title="Our Products"
            :with-pagination="true"
            :page-count="pageCount"
            :current-page="currentPage"
        />
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';

const route = useRoute();
const apiUrl: string = useRuntimeConfig().public.apiUrl;
const pageStore = usePageConfigurationStore();

const product_list = ref(pageStore.product_list);
const productListComponent = defineAsyncComponent({
    loader: () => import(`@/components/product-list/${product_list.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/product-list/default.vue`),
    timeout: 3000,
});

const products = ref<Product[]>([]);
const pageCount = ref(0);
const currentPage = ref(parseInt(route.query.page as string) || 1);

onMounted(async () => {
    await fetchProducts(currentPage.value);
});

async function fetchProducts(page: number) {
    const { data, meta } = await $fetch<{
        data: Product[];
        meta: { last_page: number };
    }>(`${apiUrl}/v1/products`, {
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
        },
        params: {
            page,
            limit: 9,
        },
    });

    products.value = data;
    pageCount.value = meta.last_page;
}

watch(
    () => route.query.page,
    (newPage) => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });

        const page = parseInt(newPage as string) || 1;
        currentPage.value = page;
        fetchProducts(page);
    }
);
</script>
