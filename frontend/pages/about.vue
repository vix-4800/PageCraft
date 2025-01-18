<template>
    <component :is="aboutComponent" />
</template>

<script lang="ts" setup>
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const template = ref(templateStore.getTemplate(TemplateBlock.About));
const aboutComponent = defineAsyncComponent({
    loader: () => import(`@/components/about/${template.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/about/default.vue`),
    timeout: 3000,
});
</script>
