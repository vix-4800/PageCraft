import { defineStore } from 'pinia';
import type { User } from '~/types/user';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null as User | null,
        authToken: null as string | null,
    }),
    actions: {
        async fetchUser() {
            const apiUrl: string = useRuntimeConfig().public.apiUrl;

            const { data } = await $fetch<{ data: User }>(`${apiUrl}/user`);

            this.user = data;
        },
        setUser(user: User) {
            this.user = user;
        },
    },
    getters: {
        isAuthenticated(state) {
            return !!state.authToken && !!state.user;
        },
    },
    persist: {
        storage: piniaPluginPersistedstate.localStorage(),
    },
});
