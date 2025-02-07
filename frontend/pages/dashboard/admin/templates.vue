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
                <site-template-selector
                    v-model="value.template"
                    mode="select"
                    :block="value.block"
                    class="mt-2"
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
