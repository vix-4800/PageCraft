import { defineStore } from 'pinia';
import type { SiteSetting } from '~/types/site_setting';

export const useSiteSettingsStore = defineStore('site_settings', {
    state: () => ({
        settings: [] as SiteSetting[],
    }),
    actions: {
        async fetch() {
            const { data } = await apiFetch<{ data: SiteSetting[] }>(
                `v1/site-settings`
            );

            this.setSettings(data);
        },
        async save(settings: SiteSetting[]) {
            withPasswordConfirmation(
                async () => {
                    const { data } = await apiFetch<{ data: SiteSetting[] }>(
                        `v1/site-settings`,
                        {
                            method: 'PUT',
                            body: settings,
                        }
                    );

                    this.setSettings(data);
                },
                'Confirm site settings update',
                'Are you sure you want to save the changes?',
                false,
                'Settings saved successfully'
            );
        },
        setSettings(settings: SiteSetting[]) {
            this.settings = settings;
        },
        getSetting(key: string) {
            return this.settings.find((setting) => setting.key === key)?.value;
        },
    },
    getters: {
        fetched: (state) => state.settings.length > 0,
    },
    persist: true,
});
