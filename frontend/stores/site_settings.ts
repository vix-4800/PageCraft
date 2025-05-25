import { defineStore } from 'pinia';
import { SettingKey, type SiteSetting } from '~/types/site_setting';

export const useSiteSettingsStore = defineStore('site_settings', {
    state: () => ({
        settings: [] as SiteSetting[],
    }),
    actions: {
        async fetch() {
            try {
                const { data } = await apiFetch<{ data: SiteSetting[] }>(
                    `v1/settings`
                );

                this.setSettings(data);
            } catch (error) {
                console.error('Settings fetch error:', error);

                showError({
                    statusCode: 500,
                    statusMessage: 'Settings fetch failed',
                });
            }
        },
        async save(settings: SiteSetting[]) {
            withPasswordConfirmation(
                async () => {
                    const { data } = await apiFetch<{ data: SiteSetting[] }>(
                        `v1/settings`,
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
        getSocialLinks() {
            const links = [
                {
                    key: 'facebook',
                    value: this.getSetting(SettingKey.SocialFacebook),
                    icon: 'mdi:facebook',
                },
                {
                    key: 'twitter',
                    value: this.getSetting(SettingKey.SocialTwitter),
                    icon: 'mdi:twitter',
                },
                {
                    key: 'instagram',
                    value: this.getSetting(SettingKey.SocialInstagram),
                    icon: 'mdi:instagram',
                },
                {
                    key: 'vk',
                    value: this.getSetting(SettingKey.SocialVk),
                    icon: 'mdi:vk',
                },
                {
                    key: 'youtube',
                    value: this.getSetting(SettingKey.SocialYoutube),
                    icon: 'mdi:youtube',
                },
                {
                    key: 'telegram',
                    value: this.getSetting(SettingKey.SocialTelegram),
                    icon: 'mdi:telegram',
                },
            ];

            return links.filter((link) => link.value);
        },
    },
    getters: {
        fetched: (state) => state.settings.length > 0,
        isMaintenance: (state) => {
            return state.settings.find(
                (setting) => setting.key === SettingKey.IsMaintenance
            )?.value;
        },
    },
    persist: true,
});
