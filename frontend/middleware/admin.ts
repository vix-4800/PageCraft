export default defineNuxtRouteMiddleware((to) => {
    const authStore = useAuthStore();

    if (to.path.startsWith('/dashboard') && !authStore.isAdmin) {
        return navigateTo('/user');
    }
});
