import { defineStore } from 'pinia';
import type { OAuthProvider } from '~/types/oauth_provider';
import { UserRole, type User } from '~/types/user';

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
            const { two_factor } = await apiFetch<{ two_factor: boolean }>(
                'auth/login',
                {
                    method: 'POST',
                    body: JSON.stringify(credentials),
                }
            );

            if (two_factor) {
                navigateTo('/two-factor');
            } else {
                await this.fetchUser();
                navigateTo(`/dashboard/${this.isAdmin ? 'admin' : 'user'}`);
            }
        },
        async register(credentials: {
            name: string;
            email: string;
            phone: string;
            password: string;
            password_confirmation: string;
        }) {
            await apiFetch('auth/register', {
                method: 'POST',
                body: JSON.stringify(credentials),
            });

            await this.fetchUser();
            navigateTo('/verify-email');
        },
        async logout(withBackend: boolean = true) {
            if (withBackend) {
                await apiFetch('auth/logout', {
                    method: 'POST',
                });
            }

            this.setUser(null);
            useCartDetailsStore().clear();
            useCookie('XSRF-TOKEN').value = '';

            navigateTo('/');
        },
        async update({
            name,
            email,
            phone,
        }: {
            name: string;
            email: string;
            phone: string;
        }) {
            await apiFetch<{ data: User }>(`auth/user/profile-information`, {
                method: 'PUT',
                body: JSON.stringify({ name, email, phone }),
            });
        },
        async fetchUser() {
            const { data } = await apiFetch<{ data: User }>(`user`);

            this.setUser(data);
            useCartDetailsStore().update();
        },
        setUser(user: User | null) {
            this.user = user;
        },
        async oauthLogin(provider: OAuthProvider) {
            const { data } = await apiFetch<{ data: { url: string } }>(
                `oauth/${provider}/redirect`
            );

            navigateTo(data.url, { external: true });
        },
        async toggleTwoFactor() {
            await apiFetch('auth/user/two-factor-authentication', {
                method: this.user?.two_factor.enabled ? 'DELETE' : 'POST',
            });

            await this.fetchUser();
        },
        async fetchTwoFactorQrCode() {
            const { svg } = await apiFetch<{ svg: string; url: string }>(
                'auth/user/two-factor-qr-code'
            );

            return svg;
        },
        async fetchTwoFactorRecoveryCodes() {
            const response = await apiFetch<string[]>(
                'auth/user/two-factor-recovery-codes'
            );

            return response;
        },
        async confirmTwoFactorCode(code: string) {
            await apiFetch('auth/two-factor-challenge', {
                method: 'POST',
                body: { code },
            });

            await this.fetchUser();
            navigateTo(`/dashboard/${this.isAdmin ? 'admin' : 'user'}`);
        },
        async resendVerificationEmail() {
            await apiFetch('auth/email/verification-notification', {
                method: 'POST',
            });
        },
        async verifyEmail(url: string) {
            await apiFetch(url);

            await this.fetchUser();
            navigateTo(`/dashboard/${this.isAdmin ? 'admin' : 'user'}`);
        },
        async confirmPassword(password: string) {
            await apiFetch('auth/user/confirm-password', {
                method: 'POST',
                body: { password },
            });
        },
        async deleteUser() {
            withPasswordConfirmation(
                async () => {
                    await apiFetch('user', {
                        method: 'DELETE',
                    });

                    await this.logout(false);
                },
                'Confirm user deletion',
                'Are you sure you want to delete your account?',
                true
            );
        },
    },
    getters: {
        isAuthenticated: (state): boolean => !!state.user,
        isAdmin: (state): boolean => state.user?.role === UserRole.ADMIN,
        isVerified: (state): boolean => !!state.user?.email_verified_at,
    },
    persist: true,
});
