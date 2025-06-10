<template>
    <div>
        <page-title title="Свяжитесь с нами" subtitle="Нужна помощь?" />

        <editable-block :name="TemplateBlock.Contact">
            <component :is="contactComponent" />
        </editable-block>
    </div>
</template>

<script lang="ts" setup>
import { TemplateBlock } from '~/types/template';

const templateStore = useSiteTemplatesStore();

const contactComponent = computed(() => {
    const template = templateStore.getTemplate(TemplateBlock.Contact);

    return defineAsyncComponent({
        loader: () => import(`@/components/contact/${template}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/contact/default.vue`),
        timeout: 3000,
    });
});
</script>
