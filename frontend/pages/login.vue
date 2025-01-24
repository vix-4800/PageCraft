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

        <u-form
            ref="form"
            :state="credentials"
            :schema="schema"
            class="space-y-4"
            @submit="submitForm"
        >
            <u-form-group size="lg" name="email">
                <u-input
                    v-model="credentials.email"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Email"
                    type="email"
                    icon="material-symbols:mail"
                />
            </u-form-group>

            <u-form-group name="password" size="lg">
                <u-input
                    v-model="credentials.password"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    type="password"
                    placeholder="Password"
                    variant="none"
                    icon="material-symbols:lock"
                />
            </u-form-group>

            <div class="flex justify-between">
                <u-checkbox
                    v-model="credentials.remember"
                    color="blue"
                    class="text-gray-100"
                >
                    <template #label>
                        <span class="italic text-gray-100">Remember me</span>
                    </template>
                </u-checkbox>

                <nuxt-link to="/reset-password">
                    <span class="text-sm text-gray-100 hover:underline">
                        Forgot password?
                    </span>
                </nuxt-link>
            </div>

            <div class="flex justify-center gap-4">
                <u-button
                    class="text-gray-100 bg-gray-800 border border-gray-600 rounded-lg shadow-xl disabled:bg-gray-800 ring-0 w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-indigo-800 hover:ring-indigo-600 hover:bg-gray-700"
                    size="lg"
                    label="Login"
                    block
                    type="submit"
                    icon="material-symbols:login-rounded"
                    :loading="loading"
                    color="gray"
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
import { z } from 'zod';
import type { FormSubmitEvent, Form } from '#ui/types';
import { OAuthProvider } from '~/types/oauth_provider';

definePageMeta({
    layout: 'auth',
});

const authStore = useAuthStore();

const schema = z.object({
    email: z.string().min(1, 'Email is required').email('Email is invalid'),
    password: z.string().min(1, 'Password is required'),
    remember: z.boolean(),
});

const form = ref<Form<Schema>>();
type Schema = z.output<typeof schema>;

const credentials = reactive({
    email: '' as string | undefined,
    password: '' as string | undefined,
    remember: true as boolean | undefined,
});

const loading = ref(false);
const submitForm = async (event: FormSubmitEvent<Schema>) => {
    form.value!.clear();
    loading.value = true;

    try {
        await authStore.login(event.data);
    } catch (err) {
        if (err?.statusCode === 422) {
            form.value!.setErrors([
                {
                    path: 'email',
                    message: err.data.errors.email[0],
                },
            ]);
        }
    } finally {
        loading.value = false;
    }
};

const githubLogin = async () => {
    await authStore.oauthLogin(OAuthProvider.GITHUB);
};

const googleLogin = async () => {
    await authStore.oauthLogin(OAuthProvider.GOOGLE);
};
</script>
