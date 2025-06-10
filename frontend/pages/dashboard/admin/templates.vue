<template>
    <div>
        <dashboard-page-name title="Page Templates" />

        <u-form :state="siteTemplatesState" class="space-y-2" @submit="save">
            <u-form-field
                v-for="(template, index) in siteTemplatesState"
                :key="index"
                :label="template.title"
                :hint="template.description"
            >
                <site-template-selector
                    v-model="template.template"
                    mode="select"
                    :name="template.name"
                />
            </u-form-field>

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
import type { SiteTemplate } from '~/types/template';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const templatesStore = useSiteTemplatesStore();
const siteTemplatesState = ref<SiteTemplate[]>([]);

const loading = ref(false);
onMounted(async () => {
    loading.value = true;

    await templatesStore.fetch();
    siteTemplatesState.value = templatesStore.templates;

    loading.value = false;
});

const save = async () => {
    loading.value = true;

    await templatesStore.setTemplates(siteTemplatesState.value);
    await templatesStore.save();
    siteTemplatesState.value = templatesStore.templates;

    loading.value = false;
};
</script>
