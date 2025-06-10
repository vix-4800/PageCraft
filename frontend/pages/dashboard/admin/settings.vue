<template>
    <div>
        <dashboard-page-name title="Settings" />

        <u-form :state="siteSettingsState" class="space-y-4" @submit="save">
            <div
                v-for="(settings, category) in groupedSettings"
                :key="category"
                class="space-y-2"
            >
                <u-separator :label="capitalize(category.replace('_', ' '))" />

                <div v-for="(setting, index) in settings" :key="index">
                    <u-form-field
                        v-if="setting.type === SettingType.TEXT"
                        :label="capitalize(setting.key.replace('_', ' '))"
                        required
                    >
                        <u-input
                            v-model="setting.value"
                            color="blue"
                            size="lg"
                            :placeholder="
                                capitalize(setting.key.replace('_', ' '))
                            "
                        />
                    </u-form-field>

                    <u-form-field
                        v-if="setting.type === SettingType.BOOLEAN"
                        :label="capitalize(setting.key.replace('_', ' '))"
                    >
                        <u-switch
                            v-model="setting.value"
                            color="blue"
                            size="lg"
                            on-icon="material-symbols:check"
                            off-icon="material-symbols:close"
                        />
                    </u-form-field>
                </div>
            </div>

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
import { SettingType } from '~/types/site_setting';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const settingStore = useSiteSettingsStore();
const siteSettingsState = ref<SiteSetting[]>([]);
const groupedSettings = ref([]);

const loading = ref(false);
onMounted(async () => {
    loading.value = true;

    await settingStore.fetch();
    siteSettingsState.value = settingStore.settings;

    groupedSettings.value = siteSettingsState.value.reduce(
        (result, setting) => {
            result[setting.category] = result[setting.category] || [];
            result[setting.category].push(setting);
            return result;
        },
        {} as { [category: string]: SiteSetting[] }
    );
    console.log(groupedSettings.value);

    loading.value = false;
});

async function save() {
    await settingStore.save(siteSettingsState.value);
    siteSettingsState.value = settingStore.settings;
}
</script>
