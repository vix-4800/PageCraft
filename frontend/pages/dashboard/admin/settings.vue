<template>
    <div>
        <DashboardPageName title="Settings" />

        <div class="space-y-4">
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
                        :label="capitalize(setting.key.replace('_', ' '))"
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
            </u-card>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { SiteSetting } from '~/types/site_setting';
import type { SiteTemplate } from '~/types/site_template';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

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
    cart: [
        { value: 'default', label: 'Default' },
        { value: 'modern', label: 'Modern' },
    ],
    contact: [{ value: 'default', label: 'Default' }],
    about: [{ value: 'default', label: 'Default' }],
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

async function saveTemplates() {
    withPasswordConfirmation(
        async () => {
            await templatesStore.save(siteTemplatesState.value);
            siteTemplatesState.value = templatesStore.templates;
        },
        'Confirm site templates update',
        'Are you sure you want to save the changes?',
        'Templates saved successfully'
    );
}

async function saveSettings() {
    withPasswordConfirmation(
        async () => {
            await settingStore.save(siteSettingsState.value);
            siteSettingsState.value = settingStore.settings;
        },
        'Confirm site settings update',
        'Are you sure you want to save the changes?',
        'Settings saved successfully'
    );
}
</script>
