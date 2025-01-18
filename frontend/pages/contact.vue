<template>
    <component :is="contactComponent" />
</template>

<script lang="ts" setup>
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const template = ref(templateStore.getTemplate(TemplateBlock.Contact));
const contactComponent = defineAsyncComponent({
    loader: () => import(`@/components/contact/${template.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/contact/default.vue`),
    timeout: 3000,
});
</script>
