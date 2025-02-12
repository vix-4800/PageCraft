<template>
    <div>
        <page-title title="Shopping Cart" />

        <editable-block :name="TemplateBlock.Cart">
            <component :is="cartComponent" />
        </editable-block>
    </div>
</template>

<script lang="ts" setup>
import { TemplateBlock } from '~/types/template';

const templateStore = useSiteTemplatesStore();

const cartComponent = computed(() => {
    const template = templateStore.getTemplate(TemplateBlock.Cart);
    return defineAsyncComponent({
        loader: () => import(`@/components/cart/${template}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/cart/default.vue`),
        timeout: 3000,
    });
});
</script>
