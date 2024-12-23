import { defineStore } from 'pinia';
import type { User } from '~/types/user';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null as User | null,
    }),
    actions: {
        async login(credentials: {
            email: string;
            password: string;
            remember: boolean;
        }) {
            await apiFetch('login', {
                method: 'POST',
                body: JSON.stringify(credentials),
            });

            await this.fetchUser();
            navigateTo('/dashboard');
        },
        async register(credentials) {
            console.log(credentials);
        },
        async logout() {
            await apiFetch('logout', {
                method: 'POST',
            });

            this.setUser(null);
        },
        async fetchUser() {
            const { data } = await apiFetch<{ data: User }>(`user`);

            this.setUser(data);
        },
        setUser(user: User | null) {
            this.user = user;
        },
    },
    getters: {
        isAuthenticated: (state) => !!state.user,
    },
    persist: true,
});
