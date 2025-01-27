<template>
    <div>
        <page-title title="Shopping Cart" />
        <component :is="cartComponent" />
    </div>
</template>

<script lang="ts" setup>
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const cartTemplate = ref(templateStore.getTemplate(TemplateBlock.Cart));
const cartComponent = defineAsyncComponent({
    loader: () => import(`@/components/cart/${cartTemplate.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/cart/default.vue`),
    timeout: 3000,
});
</script>
