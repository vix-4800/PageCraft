export default defineNuxtRouteMiddleware((to) => {
    const settingStore = useSiteSettingsStore();
    const authStore = useAuthStore();

    if (!settingStore.fetched) {
        settingStore.fetch().catch(() => {
            throw new Error('Setting fetch failed');
        });
    }

    if (
        !authStore.isAuthenticated ||
        !authStore.isAdmin ||
        !authStore.isVerified
    ) {
        if (
            settingStore.isMaintenance &&
            !['/maintenance', '/login', '/verify-email', 'two-factor'].includes(
                to.path
            )
        ) {
            return navigateTo('/maintenance');
        }
    }
});
