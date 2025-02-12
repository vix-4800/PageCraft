<template>
    <div>
        <page-title
            title="Contact Us"
            subtitle="Have some big idea or brand to develop and need help?"
        />

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
