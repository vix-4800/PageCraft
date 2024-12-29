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
            const { data } = await apiFetch<{ data: SiteSetting[] }>(
                `v1/site-settings`,
                {
                    method: 'PUT',
                    body: settings,
                }
            );

            this.setSettings(data);
        },
        setSettings(settings: SiteSetting[]) {
            this.settings = settings;
        },
    },
    persist: true,
});
