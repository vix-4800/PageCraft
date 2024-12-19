import { useAuthStore } from '../stores/auth';

export default defineNuxtRouteMiddleware((to) => {
    const { authenticated, user } = useAuthStore();

    if (!authenticated && to.path.match(/^\/(dashboard|user)/)) {
        return navigateTo('/login');
    }

    if (authenticated && to.path.match(/^\/(login|register)/)) {
        return navigateTo(user.role === 'admin' ? '/dashboard' : '/user');
    }

    if (user?.role === 'admin' && to.path.startsWith('/user')) {
        return navigateTo('/dashboard');
    }

    if (user?.role === 'user' && to.path.startsWith('/dashboard')) {
        return navigateTo('/user');
    }
});
