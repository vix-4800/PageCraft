<template>
    <div class="page-transition layout-transition">
        <component :is="headerComponent" :header-pages="headerPages" />

        <main class="min-h-screen p-4 mx-auto lg:max-w-7xl sm:px-6">
            <slot></slot>
        </main>

        <component
            :is="footerComponent"
            :footer-pages="footerPages"
            :footer-contacts="footerContacts"
        />
    </div>
</template>

<script lang="ts" setup>
import { SettingKey } from '~/types/site_setting';
import { TemplateBlock } from '~/types/site_template';

const settingsStore = useSiteSettingsStore();

onMounted(() => {
    settingsStore.fetch();
});

useHead({
    meta: [
        {
            name: 'description',
            content: settingsStore.getSetting(SettingKey.SiteDescription),
        },
        {
            name: 'keywords',
            content: settingsStore.getSetting(SettingKey.SiteKeywords),
        },
        {
            name: 'author',
            content: settingsStore.getSetting(SettingKey.SiteAuthor),
        },
    ],
    script: [
        {
            src: 'https://widget.cloudpayments.ru/bundles/cloudpayments.js',
        },
    ],
});

const templateStore = useSiteTemplatesStore();

const header = ref(templateStore.getTemplate(TemplateBlock.Header));
const headerComponent = defineAsyncComponent({
    loader: () => import(`@/components/header/${header.value}.vue`),
    delay: 200,
    errorComponent: () => import(`@/components/header/default.vue`),
    timeout: 3000,
});
const headerPages = ref([
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
const footerPages = ref([
    { name: 'Contact', href: '/contact' },
    { name: 'About', href: '/about' },
    { name: 'Terms & Conditions', href: '/terms' },
    { name: 'Privacy Policy', href: '/privacy' },
]);
const footerContacts = reactive({
    email: settingsStore.getSetting(SettingKey.SiteEmail),
    phone: settingsStore.getSetting(SettingKey.SitePhone),
    address: settingsStore.getSetting(SettingKey.SiteAddress),
});
</script>
