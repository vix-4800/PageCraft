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

            await useFetch(`${apiUrl}/auth/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                body: JSON.stringify({ email, password }),
            })
                .then((response) => {
                    useCookie('AUTH_TOKEN').value =
                        response.data.value.data.token;
                    this.authenticated = true;

                    this.fetchUser();

                    navigateTo('/dashboard');
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        // async register({ name: string, email, phone, password }) {
        //     this.user = {
        //         name: name,
        //         email: email,
        //         phone: phone,
        //         password: password,
        //     };

        //     this.authenticated = true;
        // },
        async logout() {
            const apiUrl: string = useRuntimeConfig().public.apiUrl;

            await useFetch(`${apiUrl}/auth/logout`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    Authorization: `Bearer ${this.authToken}`,
                },
            })
                .then(() => {
                    this.authenticated = false;
                    useCookie('AUTH_TOKEN').value = '';

                    this.user = {
                        name: '',
                        email: '',
                        phone: '',
                    };

                    navigateTo('/');
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        async fetchUser() {
            const apiUrl: string = useRuntimeConfig().public.apiUrl;

            const response = await $fetch<{ data: User }>(`${apiUrl}/v1/user`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    Authorization: `Bearer ${this.authToken}`,
                },
            });

            this.user = response.data;
        },
    },
});
