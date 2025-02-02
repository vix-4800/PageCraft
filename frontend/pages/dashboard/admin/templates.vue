<template>
    <div>
        <dashboard-page-name title="Page Templates" />

        <u-form
            :state="siteTemplatesState"
            class="flex flex-col gap-2 px-1"
            @submit="save"
        >
            <u-form-group
                v-for="(value, index) in siteTemplatesState"
                :key="index"
                :label="capitalize(value.block.replace('_', ' '))"
            >
                <u-select-menu
                    v-model="value.template"
                    color="blue"
                    :disabled="templateOptions[value.block as keyof typeof templateOptions].length === 1"
                    :options="templateOptions[value.block as keyof typeof templateOptions]"
                    size="lg"
                    :ui-menu="{
                        height: 'max-h-96',
                    }"
                    :value-attribute="'value'"
                >
                    <template #option="{ option: { img } }">
                        <nuxt-img :src="img" />
                    </template>
                </u-select-menu>
            </u-form-group>

            <u-button
                icon="material-symbols:save"
                type="submit"
                size="md"
                color="blue"
                class="mt-2 w-min"
                label="Save"
                :loading="loading"
            />
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import type { SiteTemplate } from '~/types/site_template';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const templatesStore = useSiteTemplatesStore();
const siteTemplatesState = ref<SiteTemplate[]>([]);

const templateOptions = {
    header: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/header_default.png',
        },
        {
            value: 'minimalistic',
            label: 'Minimalistic',
            img: 'images/templates/header_minimalistic.png',
        },
    ],
    footer: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/footer_default.png',
        },
        {
            value: 'minimalistic',
            label: 'Minimalistic',
            img: 'images/templates/footer_minimalistic.png',
        },
        {
            value: 'simple',
            label: 'Simple',
            img: 'images/templates/footer_simple.png',
        },
        {
            value: 'contact',
            label: 'Contact Details',
            img: 'images/templates/footer_contact.png',
        },
    ],
    product_list: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/product_list_default.png',
        },
        {
            value: 'modern',
            label: 'Modern',
            img: 'images/templates/product_list_modern.png',
        },
        {
            value: 'compact',
            label: 'Compact',
            img: 'images/templates/product_list_compact.png',
        },
    ],
    product_detail: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/product_detail_default.png',
        },
        {
            value: 'modern',
            label: 'Modern',
            img: 'images/templates/product_detail_modern.png',
        },
    ],
    cart: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/cart_default.png',
        },
        {
            value: 'modern',
            label: 'Modern',
            img: 'images/templates/cart_modern.png',
        },
    ],
    contact: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/contact_default.png',
        },
    ],
    about: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/about_default.png',
        },
    ],
    article_list: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/article_list_default.png',
        },
    ],
    article_detail: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/article_detail_default.png',
        },
    ],
};

const loading = ref(false);
onMounted(async () => {
    loading.value = true;

    await templatesStore.fetch();
    siteTemplatesState.value = templatesStore.templates;

    loading.value = false;
});

const save = async () => {
    loading.value = true;

    await templatesStore.save(siteTemplatesState.value);
    siteTemplatesState.value = templatesStore.templates;

    loading.value = false;
};
</script>
