export default defineNuxtRouteMiddleware((to) => {
    const authStore = useAuthStore();

    // Redirect to dashboard if already logged in
    if (
        (to.path === '/login' || to.path === '/register') &&
        authStore.isAuthenticated
    ) {
        const dashboard = authStore.isAdmin ? 'admin' : 'user';
        return navigateTo(`/dashboard/${dashboard}`);
    }

    if (to.path.startsWith('/dashboard')) {
        // Redirect to login if not logged in
        if (!authStore.isAuthenticated) {
            return navigateTo('/login');
        }

        // Redirect to correct dashboard
        const dashboard = authStore.isAdmin ? 'admin' : 'user';
        if (!to.path.startsWith(`/dashboard/${dashboard}`)) {
            return navigateTo(`/dashboard/${dashboard}`);
        }
    }
});
