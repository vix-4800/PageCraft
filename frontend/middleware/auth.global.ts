export default defineNuxtRouteMiddleware((to) => {
    const authStore = useAuthStore();

    // Redirect to dashboard if already logged in
    if (
        authStore.isAuthenticated &&
        (to.path === '/login' || to.path === '/register')
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
        const commonRoutes = ['/dashboard/account', '/dashboard/my-orders'];
        if (
            !to.path.startsWith(`/dashboard/${dashboard}`) &&
            !commonRoutes.includes(to.path)
        ) {
            return navigateTo(`/dashboard/${dashboard}`);
        }
    }
});
