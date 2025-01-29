export default defineNuxtRouteMiddleware(() => {
    if (!useAuthStore().isVerified) {
        return navigateTo('/verify-email');
    }
});
