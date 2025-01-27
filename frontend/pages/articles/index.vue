<template>
    <div>
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
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const articleList = ref(templateStore.getTemplate(TemplateBlock.ArticleList));
const articleListComponent = defineAsyncComponent({
    loader: () => import(`@/components/article-list/${articleList.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/article-list/default.vue`),
    timeout: 3000,
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
