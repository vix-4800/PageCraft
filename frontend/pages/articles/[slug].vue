<template>
    <component :is="articleDetailComponent" :article="article" />
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const articleDetail = ref(
    templateStore.getTemplate(TemplateBlock.ArticleDetail)
);
const articleDetailComponent = defineAsyncComponent({
    loader: () =>
        import(`@/components/article-detail/${articleDetail.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/article-detail/default.vue`),
    timeout: 3000,
});

const route = useRoute();

const article = ref<Article | null>(null);
onMounted(async () => {
    const { data } = await apiFetch<{ data: Article }>(
        `v1/articles/${route.params.slug}`
    );
    article.value = data;
});
</script>
