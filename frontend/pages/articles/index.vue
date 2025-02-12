<template>
    <div>
        <page-title title="Articles" subtitle="Our latest news and updates" />

        <editable-block :name="TemplateBlock.ArticleList">
            <component
                :is="articleListComponent"
                :articles="articles"
                title="Articles"
                :loading="articlesLoading"
            />
        </editable-block>
    </div>
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';
import { TemplateBlock } from '~/types/template';

const templateStore = useSiteTemplatesStore();

const articleListComponent = computed(() => {
    const template = templateStore.getTemplate(TemplateBlock.ArticleList);
    return defineAsyncComponent({
        loader: () => import(`@/components/article-list/${template}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/article-list/default.vue`),
        timeout: 3000,
    });
});

const articles = ref<Article[]>([]);
const articlesLoading = ref(false);

onMounted(async () => {
    await getArticles();
});

const getArticles = async () => {
    articlesLoading.value = true;

    const { data } = await apiFetch<{ data: Article[] }>('v1/articles', {
        params: {
            limit: 9,
        },
    });

    articles.value = data;
    articlesLoading.value = false;
};
</script>
