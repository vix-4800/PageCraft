import { log } from 'console';
import { defineStore } from 'pinia';
import type { User } from '~/types/user';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authenticated: !!useCookie('AUTH_TOKEN').value,
        user: {} as User,
        authToken: useCookie('AUTH_TOKEN', {
            sameSite: 'strict',
            secure: true,
            maxAge: 60 * 60 * 24 * 5, // 5 days
        }),
    }),
    actions: {
        async login(email: string, password: string) {
            const apiUrl: string = useRuntimeConfig().public.apiUrl;

            const { data } = await $fetch<{ data: { token: string } }>(
                `${apiUrl}/auth/login`,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({ email, password }),
                }
            );

            useCookie('AUTH_TOKEN').value = data.token;
            this.authToken = data.token;
            this.authenticated = true;

            await this.fetchUser();

            if (this.user.role === 'admin') {
                navigateTo('/dashboard');
            } else {
                navigateTo('/user');
            }
        },
        async logout() {
            const apiUrl: string = useRuntimeConfig().public.apiUrl;

            await useFetch(`${apiUrl}/auth/logout`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    Authorization: `Bearer ${this.authToken}`,
                },
            });

            this.authenticated = false;
            useCookie('AUTH_TOKEN').value = '';

            this.user = {} as User;

            navigateTo('/');
        },
        async fetchUser() {
            const apiUrl: string = useRuntimeConfig().public.apiUrl;

            const { data } = await $fetch<{ data: User }>(
                `${apiUrl}/v1/users/me`,
                {
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        Authorization: `Bearer ${this.authToken}`,
                    },
                }
            );

            this.user = data;
        },
    },
});
