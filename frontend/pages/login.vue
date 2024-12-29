<template>
    <div>
        <div class="flex justify-center mb-4">
            <nuxt-link
                to="/"
                class="w-24 transition duration-200 opacity-50 hover:opacity-100 max-h-24"
            >
                <nuxt-img
                    src="/logo.png"
                    :alt="useRuntimeConfig().public.appName"
                />
            </nuxt-link>
        </div>

        <u-form :state="credentials" class="space-y-6" @submit="submitForm">
            <u-form-group size="lg" name="email" required>
                <u-input
                    v-model="credentials.email"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Email"
                    type="email"
                    required
                    icon="material-symbols:mail"
                />
            </u-form-group>

            <u-form-group name="password" size="lg" required>
                <u-input
                    v-model="credentials.password"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    type="password"
                    placeholder="Password"
                    required
                    variant="none"
                    icon="material-symbols:lock"
                />
            </u-form-group>

            <u-checkbox
                v-model="credentials.remember"
                color="blue"
                class="text-gray-100"
            >
                <template #label>
                    <span class="italic text-gray-100">Remember me</span>
                </template>
            </u-checkbox>

            <div class="flex justify-center gap-4">
                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    label="Login"
                    block
                    type="submit"
                    icon="material-symbols:login-rounded"
                />

                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    label="Register"
                    block
                    to="/register"
                    icon="material-symbols:person-add"
                />
            </div>
        </u-form>

        <u-divider
            label="Or login with"
            :ui="{
                border: { base: 'border-gray-500' },
                label: 'text-gray-500',
                container: { horizontal: 'my-4' },
            }"
        />

        <div class="flex justify-center gap-4">
            <u-button
                class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                size="lg"
                label="Google"
                icon="ri:google-fill"
                @click="googleLogin"
            />
            <u-button
                class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                size="lg"
                label="GitHub"
                icon="ri:github-fill"
                @click="githubLogin"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { OAuthProvider } from '~/types/oauth_provider';

definePageMeta({
    layout: 'auth',
});

const credentials = reactive({
    email: '',
    password: '',
    remember: true,
});

const authStore = useAuthStore();
const submitForm = async () => {
    await authStore.login(credentials);
};

const githubLogin = async () => {
    await authStore.oauthLogin(OAuthProvider.GITHUB);
};

const googleLogin = async () => {
    await authStore.oauthLogin(OAuthProvider.GOOGLE);
};
</script>
