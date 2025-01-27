<template>
    <div class="page-transition layout-transition">
        <banner-announcement
            text="Don't miss out on our amazing summer sale! Get up to 50% off on a wide range of products. Make the most of your summer shopping."
        />

        <component :is="headerComponent" :header-pages="headerPages" />

        <main
            class="min-h-screen font-[sans-serif] p-4 mx-auto lg:max-w-7xl sm:px-6"
        >
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
            content: settingsStore.getSetting(SettingKey.Description),
        },
        {
            name: 'keywords',
            content: settingsStore.getSetting(SettingKey.Keywords),
        },
        {
            name: 'author',
            content: settingsStore.getSetting(SettingKey.Author),
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
    {
        name: 'Articles',
        href: '/articles',
        icon: 'material-symbols:article',
    },
    { name: 'About', href: '/about', icon: 'material-symbols:info' },
    {
        name: 'Contact',
        href: '/contact',
        icon: 'material-symbols:contact-page',
    },
    { name: 'FAQ', href: '/faq', icon: 'material-symbols:help' },
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
    email: settingsStore.getSetting(SettingKey.Email),
    phone: settingsStore.getSetting(SettingKey.Phone),
    address: settingsStore.getSetting(SettingKey.Address),
});
</script>
