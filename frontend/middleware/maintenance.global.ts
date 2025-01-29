import { SettingKey } from '~/types/site_setting';

export default defineNuxtRouteMiddleware((to) => {
    const settingStore = useSiteSettingsStore();
    // const inMaintenance = settingStore.getSetting(SettingKey.Maintenance);

    // if (inMaintenance && to.path !== '/maintenance') {
    //     return navigateTo('/maintenance');
    // }
});
