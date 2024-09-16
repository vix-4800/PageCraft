import { defineStore } from 'pinia';
import type { UserInterface } from '@/types/user';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authenticated: false,
        user: {
            name: '',
            email: '',
            phone: '',
        } as UserInterface,
        authToken: '',
    }),
    getters: {
        isAuthenticated: (state) => state.authenticated,
        getUser: (state) => state.user,
        getAuthToken: (state) => state.authToken,
    },
    actions: {
        async login(email: string, password: string) {
            const config = useRuntimeConfig();
            const apiUrl = config.public.apiUrl;

            await useFetch(`${apiUrl}/auth/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            })
                .then((response) => {
                    this.authToken = response.data.value.data.token;

                    this.fetchUser();

                    this.authenticated = true;
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
            const config = useRuntimeConfig();
            const apiUrl = config.public.apiUrl;

            await useFetch(`${apiUrl}/auth/logout`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${this.authToken}`,
                },
            })
                .then(() => {
                    this.authenticated = false;
                    this.authToken = '';

                    this.user = {
                        name: '',
                        email: '',
                        phone: '',
                    };
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        async fetchUser() {
            const config = useRuntimeConfig();
            const apiUrl = config.public.apiUrl;

            await useFetch(`${apiUrl}/v1/user`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${this.authToken}`,
                },
            })
                .then((response) => {
                    const user = response.data.value.data;
                    this.user = {
                        name: user.name,
                        email: user.email,
                        phone: user.phone,
                    };
                    console.log(this.user);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
});
