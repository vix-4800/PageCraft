<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Settings</h2>
        </div>
        <div class="p-6 space-y-4">
            <u-card :ui="{ background: 'bg-slate-100' }">
                <template #header>
                    <h3 class="text-lg font-semibold">General</h3>
                </template>

                <u-form
                    :state="siteSettingsState"
                    class="flex flex-col gap-2 px-1"
                    @submit="saveSettings"
                >
                    <u-form-group
                        v-for="(setting, index) in siteSettingsState"
                        :key="index"
                        :label="setting.key"
                        required
                    >
                        <u-input
                            v-model="setting.value"
                            color="blue"
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
                        :disabled="loading"
                    />
                </u-form>
            </u-card>

            <u-card :ui="{ background: 'bg-slate-100' }">
                <template #header>
                    <h3 class="text-lg font-semibold">Page Templates</h3>
                </template>

                <u-form
                    :state="siteTemplatesState"
                    class="flex flex-col gap-2 px-1"
                    @submit="saveTemplates"
                >
                    <u-form-group
                        v-for="(value, index) in siteTemplatesState"
                        :key="index"
                        :label="value.block"
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
                        :disabled="loading"
                    />
                </u-form>
            </u-card>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { SiteSetting } from '~/types/site_setting';
import type { SiteTemplate } from '~/types/site_template';

definePageMeta({
    layout: 'dashboard',
    middleware: [],
});

const { $notify } = useNuxtApp();
const templatesStore = useSiteTemplatesStore();
const settingStore = useSiteSettingsStore();

const siteTemplatesState = ref<SiteTemplate[]>([]);
const siteSettingsState = ref<SiteSetting[]>([]);

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
};

const loading = ref(false);
onMounted(async () => {
    loading.value = true;

    await templatesStore.fetch();
    siteTemplatesState.value = templatesStore.templates;

    await settingStore.fetch();
    siteSettingsState.value = settingStore.settings;

    loading.value = false;
});

const saveTemplates = async () => {
    loading.value = true;

    await templatesStore.save(siteTemplatesState.value);
    siteTemplatesState.value = templatesStore.templates;

    loading.value = false;

    $notify('Configuration saved successfully', 'success');
};

const saveSettings = async () => {
    loading.value = true;

    await settingStore.save(siteSettingsState.value);
    siteSettingsState.value = settingStore.settings;

    loading.value = false;

    $notify('Settings saved successfully', 'success');
};
</script>
