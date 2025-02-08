<template>
    <editable-block :block="TemplateBlock.ArticleDetail">
        <component :is="articleDetailComponent" :article="article" />
    </editable-block>
</template>

<script lang="ts" setup>
import type { Article } from '~/types/article';
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const articleDetailComponent = computed(() => {
    const template = templateStore.getTemplate(TemplateBlock.ArticleDetail);

    return defineAsyncComponent({
        loader: () => import(`@/components/article-detail/${template}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/article-detail/default.vue`),
        timeout: 3000,
    });
});

const route = useRoute();

const article = ref<Article | null>(null);
onMounted(async () => {
    try {
        const { data } = await apiFetch<{ data: Article }>(
            `v1/articles/${route.params.slug}`
        );

        article.value = data;
    } catch (error) {
        if (error.status === 404) {
            throw createError({
                statusCode: 404,
                statusMessage: 'Article not found',
                fatal: true,
            });
        }
    }
});
</script>
