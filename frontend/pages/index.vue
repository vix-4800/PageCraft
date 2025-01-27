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

        <component
            :is="articleListComponent"
            :articles="articles"
            title="Articles"
            :loading="articlesLoading"
        />
    </div>
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';
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

const popularProducts = ref<Product[]>([]);
const popularProductsLoading = ref(true);

const newProducts = ref<Product[]>([]);
const newProductsLoading = ref(true);

const articles = ref<Article[]>([]);
const articlesLoading = ref(false);

const articleList = ref(templateStore.getTemplate(TemplateBlock.ArticleList));
const articleListComponent = defineAsyncComponent({
    loader: () => import(`@/components/article-list/${articleList.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/article-list/default.vue`),
    timeout: 3000,
});

onMounted(async () => {
    await getPopularProducts();
    await getNewProducts();
    await getArticles();
});

const getPopularProducts = async () => {
    const { data } = await apiFetch<{ data: Product[] }>(
        `v1/products/popular`,
        {
            params: {
                limit: productList.value === 'compact' ? 4 : 6,
            },
        }
    );

    popularProducts.value = data;
    popularProductsLoading.value = false;
};

const getNewProducts = async () => {
    const { data } = await apiFetch<{ data: Product[] }>(`v1/products/new`, {
        params: {
            limit: productList.value === 'compact' ? 4 : 6,
        },
    });

    newProducts.value = data;
    newProductsLoading.value = false;
};

const getArticles = async () => {
    articlesLoading.value = true;

    const { data } = await apiFetch<{ data: Article[] }>('v1/articles', {
        params: {
            limit: 6,
        },
    });

    articles.value = data;
    articlesLoading.value = false;
};
</script>
