<template>
    <div class="page-transition layout-transition">
        <component :is="headerComponent" :pages="pages" />

        <main class="min-h-screen p-4 mx-auto lg:max-w-7xl sm:px-6">
            <slot></slot>
        </main>

        <component :is="footerComponent" />
    </div>
</template>

<script lang="ts" setup>
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const header = ref(templateStore.getTemplate(TemplateBlock.Header));
const headerComponent = defineAsyncComponent({
    loader: () => import(`@/components/header/${header.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/header/default.vue`),
    timeout: 3000,
});

const pages = ref([
    { name: 'Home', href: '/', icon: 'material-symbols:home' },
    {
        name: 'Products',
        href: '/products',
        icon: 'material-symbols:storefront',
    },
]);

const footer = ref(templateStore.getTemplate(TemplateBlock.Footer));
const footerComponent = defineAsyncComponent({
    loader: () => import(`@/components/footer/${footer.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/footer/default.vue`),
    timeout: 3000,
});
</script>
