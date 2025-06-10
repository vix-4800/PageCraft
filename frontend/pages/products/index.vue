<template>
    <div>
        <page-title title="Товары" subtitle="Популярные товары" />

        <editable-block :name="TemplateBlock.ProductList">
            <component
                :is="productListComponent"
                :products="products"
                title="Наши товары"
                :with-pagination="true"
                :page-count="pageCount"
                :current-page="currentPage"
            />
        </editable-block>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';
import { TemplateBlock } from '~/types/template';

const route = useRoute();
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
const pageCount = ref(0);
const currentPage = ref(parseInt(route.query.page as string) || 1);

onMounted(async () => {
    await fetchProducts(currentPage.value);
});

async function fetchProducts(page: number) {
    const { data, meta } = await apiFetch<{
        data: Product[];
        meta: { last_page: number };
    }>(`v1/products`, {
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
