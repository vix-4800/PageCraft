export default defineNuxtRouteMiddleware((to) => {
    // Redirect to correct dashboard
    if (!to.path.startsWith(`/dashboard`)) {
        return navigateTo(
            `/dashboard/${useAuthStore().isAdmin ? 'admin' : 'user'}`
        );
    }
});
