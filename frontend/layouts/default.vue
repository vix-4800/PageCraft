<template>
    <div class="page-transition layout-transition">
        <admin-panel v-if="authStore.isAuthenticated && authStore.isAdmin" />

        <div v-if="templateStore.isLoading" class="flex justify-center">
            <u-icon name="svg-spinners:6-dots-rotate" size="104" />
        </div>

        <div
            v-else
            :class="{
                'm-2 border-8 border-gray-300 rounded-md':
                    editModeStore.enabled,
            }"
        >
            <banner-maintenance
                v-if="settingsStore.isMaintenance"
                text="The site is currently under maintenance."
            />

            <banner-announcement
                v-if="banner && banner.is_active"
                :text="banner.text"
                :link="banner.link"
            />

            <editable-block :name="TemplateBlock.Header">
                <header
                    v-if="templateStore.isBlockVisible(TemplateBlock.Header)"
                >
                    <component
                        :is="headerComponent"
                        :header-pages="HeaderPages"
                    />
                </header>
            </editable-block>

            <main
                class="min-h-screen font-[sans-serif] p-4 mx-auto lg:max-w-7xl sm:px-6"
            >
                <slot></slot>
            </main>

            <editable-block :name="TemplateBlock.Footer">
                <footer>
                    <component
                        :is="footerComponent"
                        :footer-pages="FooterPages"
                        :footer-contacts="footerContacts"
                    />
                </footer>
            </editable-block>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Banner } from '~/types/banner';
import { SettingKey } from '~/types/site_setting';
import { TemplateBlock } from '~/types/template';
import { HeaderPages, FooterPages } from '~/config/pages';

const settingsStore = useSiteSettingsStore();
const templateStore = useSiteTemplatesStore();
const editModeStore = useEditModeStore();
const authStore = useAuthStore();
const config = useRuntimeConfig();

const banner = ref<Banner | null>();
onMounted(async () => {
    await templateStore.fetch();
    await settingsStore.fetch().then(() => {
        if (settingsStore.isMaintenance) {
            // navigateTo('/maintenance');
        }
    });

    const { data } = await apiFetch<{ data: Banner }>(`v1/banners`);
    banner.value = data;
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
    htmlAttrs: {
        lang: 'en',
    },
    link: [
        {
            rel: 'icon',
            type: 'image/png',
            href: '/favicon.png',
        },
    ],
});

useScript(`https://widget.cloudpayments.ru/bundles/cloudpayments.js`);

useSeoMeta({
    ogImage: '[og:image]',
    twitterTitle: config.public.appName,
    twitterDescription: settingsStore.getSetting(SettingKey.Description),
    twitterImage: '../public/logo.png',
    twitterCard: 'summary',
});

const headerComponent = computed(() => {
    const templateName = templateStore.getTemplate(TemplateBlock.Header);
    return defineAsyncComponent({
        loader: () => import(`@/components/header/${templateName}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/header/default.vue`),
        timeout: 3000,
    });
});

const footerComponent = computed(() => {
    const templateName = templateStore.getTemplate(TemplateBlock.Footer);
    return defineAsyncComponent({
        loader: () => import(`@/components/footer/${templateName}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/footer/default.vue`),
        timeout: 3000,
    });
});
const footerContacts = reactive({
    email: settingsStore.getSetting(SettingKey.Email),
    phone: settingsStore.getSetting(SettingKey.Phone),
    address: settingsStore.getSetting(SettingKey.Address),
});
</script>
