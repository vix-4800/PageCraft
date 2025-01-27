<template>
    <div>
        <dashboard-page-name title="Settings" />

        <u-form
            :state="siteSettingsState"
            class="flex flex-col gap-2 px-1"
            @submit="save"
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
                    :placeholder="capitalize(setting.key.replace('_', ' '))"
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
import type { SiteSetting } from '~/types/site_setting';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const settingStore = useSiteSettingsStore();
const siteSettingsState = ref<SiteSetting[]>([]);

const loading = ref(false);
onMounted(async () => {
    loading.value = true;

    await settingStore.fetch();
    siteSettingsState.value = settingStore.settings;

    loading.value = false;
});

async function save() {
    await settingStore.save(siteSettingsState.value);
    siteSettingsState.value = settingStore.settings;
}
</script>
