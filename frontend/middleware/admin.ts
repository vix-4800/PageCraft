export default defineNuxtRouteMiddleware((to, from) => {
    const authStore = useAuthStore();

    if (to.path.startsWith('/dashboard') && !authStore.isAdmin) {
        return navigateTo('/user');
    }
});
