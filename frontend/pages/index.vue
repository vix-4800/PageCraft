<template>
    <div>
        <section v-if="newProducts.length" id="new">
            <page-title
                title="Новинки"
                subtitle="Новые товары нашего магазина"
            />

            <editable-block :name="TemplateBlock.ProductList">
                <component
                    :is="productListComponent"
                    :products="newProducts"
                    title="Новинки"
                    :loading="newProductsLoading"
                />
            </editable-block>

            <u-divider class="my-10" />
        </section>

        <section v-if="popularProducts.length" id="popular">
            <page-title
                title="Популярные товары"
                subtitle="Товары, которые сейчас в тренде"
            />

            <editable-block :name="TemplateBlock.ProductList">
                <component
                    :is="productListComponent"
                    :products="popularProducts"
                    title="Популярные товары"
                    :loading="popularProductsLoading"
                />
            </editable-block>

            <u-divider class="my-10" />
        </section>

        <section v-if="articles.length" id="articles">
            <page-title title="Статьи" subtitle="Статьи из нашего блога" />

            <editable-block :name="TemplateBlock.ArticleList">
                <component
                    :is="articleListComponent"
                    :articles="articles"
                    title="Статьи"
                    :loading="articlesLoading"
                />
            </editable-block>
        </section>
    </div>
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';
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

const popularProducts = ref<Product[]>([]);
const popularProductsLoading = ref(true);

const newProducts = ref<Product[]>([]);
const newProductsLoading = ref(true);

const articles = ref<Article[]>([]);
const articlesLoading = ref(false);

const articleListComponent = computed(() => {
    const template = templateStore.getTemplate(TemplateBlock.ArticleList);
    return defineAsyncComponent({
        loader: () => import(`@/components/article-list/${template}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/article-list/default.vue`),
        timeout: 3000,
    });
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
                limit: 6,
            },
        }
    );

    popularProducts.value = data;
    popularProductsLoading.value = false;
};

const getNewProducts = async () => {
    const { data } = await apiFetch<{ data: Product[] }>(`v1/products/new`, {
        params: {
            limit: 6,
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
