import { defineStore } from 'pinia';
import type { UserInterface } from '@/types/user';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authenticated: false,
        user: {
            name: '',
            email: '',
            phone: '',
            password: '',
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
            // !TODO: Implement login

            this.user = {
                name: 'Test User',
                email: email,
                phone: '+1234567890',
                password,
            };

            this.authenticated = true;
        },
        async register({ name, email, phone, password }: UserInterface) {
            // !TODO: Implement register

            this.user = {
                name: name,
                email: email,
                phone: phone,
                password: password,
            };

            this.authenticated = true;
        },
        async logout() {
            // !TODO: Implement logout

            this.user = {
                name: '',
                email: '',
                phone: '',
                password: '',
            };

            this.authenticated = false;
        },
    },
});
