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
                <u-select
                    v-model="value.template"
                    color="blue"
                    :options="templateOptions[value.block as keyof typeof templateOptions]"
                    size="lg"
                />
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
        { value: 'default', label: 'Default' },
        { value: 'minimalistic', label: 'Minimalistic' },
    ],
    footer: [
        { value: 'default', label: 'Default' },
        { value: 'minimalistic', label: 'Minimalistic' },
        { value: 'simple', label: 'Simple' },
        { value: 'contact', label: 'Contact Details' },
    ],
    product_list: [
        { value: 'default', label: 'Default' },
        { value: 'modern', label: 'Modern' },
        { value: 'compact', label: 'Compact' },
    ],
    product_detail: [
        { value: 'default', label: 'Default' },
        { value: 'modern', label: 'Modern' },
    ],
    cart: [
        { value: 'default', label: 'Default' },
        { value: 'modern', label: 'Modern' },
    ],
    contact: [{ value: 'default', label: 'Default' }],
    about: [{ value: 'default', label: 'Default' }],
    article_list: [{ value: 'default', label: 'Default' }],
    article_detail: [{ value: 'default', label: 'Default' }],
};

const loading = ref(false);
onMounted(async () => {
    loading.value = true;

    await templatesStore.fetch();
    siteTemplatesState.value = templatesStore.templates;

    loading.value = false;
});

async function save() {
    await templatesStore.save(siteTemplatesState.value);
    siteTemplatesState.value = templatesStore.templates;
}
</script>
