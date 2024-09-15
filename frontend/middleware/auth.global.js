import { useAuthStore } from '../stores/auth';

export default defineNuxtRouteMiddleware((to) => {
    const isAuthenticated = useAuthStore().isAuthenticated;

    if (to.path.startsWith('/dashboard') && !isAuthenticated) {
        return navigateTo('/login');
    }

    if (
        (to.path.startsWith('/login') || to.path.startsWith('/register')) &&
        isAuthenticated
    ) {
        return navigateTo('/dashboard');
    }
});
