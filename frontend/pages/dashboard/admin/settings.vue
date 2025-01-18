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
                    @submit="confirmSave"
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
                        :disabled="loading"
                    />
                </u-form>
            </u-card>
        </div>

        <u-modal v-model="isConfirmModalOpen">
            <div class="p-4">
                <h3 class="text-lg font-semibold">
                    Confirm site settings update
                </h3>

                <p class="mb-4 text-sm text-gray-600">
                    Are you sure you want to update site settings?
                </p>

                <u-form-group label="Password" name="password" required>
                    <u-input
                        v-model="password"
                        color="blue"
                        size="md"
                        type="password"
                        label="Password"
                        required
                    />
                </u-form-group>

                <div class="flex justify-end gap-2 mt-4">
                    <u-button
                        color="red"
                        label="Cancel"
                        @click="isConfirmModalOpen = false"
                    />
                    <u-button
                        color="blue"
                        label="Update"
                        @click="saveSettings"
                    />
                </div>
            </div>
        </u-modal>
    </div>
</template>

<script lang="ts" setup>
import type { SiteSetting } from '~/types/site_setting';
import type { SiteTemplate } from '~/types/site_template';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

const { $notify } = useNuxtApp();
const templatesStore = useSiteTemplatesStore();
const settingStore = useSiteSettingsStore();
const authStore = useAuthStore();

const isConfirmModalOpen = ref(false);
const password = ref('');

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

const confirmSave = () => {
    isConfirmModalOpen.value = true;
};

const saveSettings = async () => {
    loading.value = true;

    await authStore.confirmPassword(password.value);
    await settingStore.save(siteSettingsState.value);
    siteSettingsState.value = settingStore.settings;

    loading.value = false;

    isConfirmModalOpen.value = false;
    password.value = '';

    $notify('Settings saved successfully', 'success');
};
</script>
