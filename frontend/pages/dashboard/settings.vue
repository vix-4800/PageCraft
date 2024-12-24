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
                    @submit="saveSiteSettings"
                >
                    <u-form-group
                        v-for="(setting, index) in siteSettingsState"
                        :key="index"
                        :label="setting.key"
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
                    <h3 class="text-lg font-semibold">Page Styles</h3>
                </template>

                <u-form
                    :state="pageConfigurationState"
                    class="flex flex-col gap-2 px-1"
                    @submit="saveConfiguration"
                >
                    <div class="flex gap-4">
                        <u-form-group label="Header" class="w-1/2">
                            <u-select
                                v-model="pageConfigurationState.header"
                                color="blue"
                                :options="headerStylesOptions"
                                size="lg"
                            />
                        </u-form-group>
                        <u-form-group label="Footer" class="w-1/2">
                            <u-select
                                v-model="pageConfigurationState.footer"
                                color="blue"
                                :options="footerStylesOptions"
                                size="lg"
                            />
                        </u-form-group>
                    </div>

                    <u-form-group label="Product List">
                        <u-select
                            v-model="pageConfigurationState.product_list"
                            color="blue"
                            :options="productListStylesOptions"
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
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'admin'],
});

const { $notify } = useNuxtApp();
const pageStore = usePageConfigurationStore();

const pageConfigurationState = reactive({
    header: pageStore.header,
    product_list: pageStore.product_list,
    footer: pageStore.footer,
});

const headerStylesOptions = [
    { value: 'default', label: 'Default' },
    { value: 'minimalistic', label: 'Minimalistic' },
];

const footerStylesOptions = [
    { value: 'default', label: 'Default' },
    { value: 'minimalistic', label: 'Minimalistic' },
];

const productListStylesOptions = [
    { value: 'default', label: 'Default' },
    { value: 'modern', label: 'Modern' },
];

const loading = ref(false);
onMounted(async () => {
    loading.value = true;

    await getPageConfiguration();
    await getSiteSettings();

    loading.value = false;
});

async function getPageConfiguration() {
    await pageStore.getConfig();

    pageConfigurationState.header = pageStore.header;
    pageConfigurationState.footer = pageStore.footer;
    pageConfigurationState.product_list = pageStore.product_list;
}
const saveConfiguration = async () => {
    loading.value = true;
    await pageStore.saveConfiguration(pageConfigurationState);
    loading.value = false;

    $notify('Configuration saved successfully', 'success');
};

const siteSettingsState = ref({});
async function getSiteSettings() {
    const { data } = await apiFetch<{ data: PageConfiguration }>(
        `v1/site-settings`
    );

    siteSettingsState.value = data;
}
const saveSiteSettings = async () => {
    loading.value = true;

    await apiFetch<{ data: PageConfiguration }>(`v1/site-settings`, {
        method: 'PUT',
        body: siteSettingsState.value,
    });

    loading.value = false;
};
</script>
