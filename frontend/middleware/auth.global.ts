export default defineNuxtRouteMiddleware((to) => {
    const authStore = useAuthStore();

    // Redirect to login if not logged in
    if (to.path.startsWith('/dashboard') && !authStore.isAuthenticated) {
        return navigateTo('/login');
    }

    // Redirect to dashboard if already logged in
    if (
        authStore.isAuthenticated &&
        (to.path === '/login' || to.path === '/register')
    ) {
        return navigateTo(`/dashboard/${authStore.isAdmin ? 'admin' : 'user'}`);
    }
});
