export default defineNuxtRouteMiddleware(() => {
    const authStore = useAuthStore();

    if (!authStore.isVerified) {
        return navigateTo('/verify-email');
    }
});
