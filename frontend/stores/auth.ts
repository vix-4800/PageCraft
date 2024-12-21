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
