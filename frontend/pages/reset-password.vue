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
            :state="state"
            :schema="schema"
            class="space-y-4"
            @submit="submitForm"
        >
            <u-form-group size="lg" name="email">
                <u-input
                    v-model="state.email"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Email"
                    type="email"
                    icon="material-symbols:mail"
                />
            </u-form-group>

            <div class="flex justify-center gap-4">
                <u-button
                    class="text-gray-100 bg-gray-800 border border-gray-600 rounded-lg shadow-xl disabled:bg-gray-800 ring-0 w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-indigo-800 hover:ring-indigo-600 hover:bg-gray-700"
                    size="lg"
                    label="Send Email"
                    block
                    type="submit"
                    icon="material-symbols:send"
                    :loading="loading"
                    color="gray"
                />

                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    label="Back"
                    block
                    to="/login"
                    icon="material-symbols:login-rounded"
                />
            </div>
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import { z } from 'zod';
import type { FormSubmitEvent, Form } from '#ui/types';

definePageMeta({
    layout: 'auth',
});

const authStore = useAuthStore();

const schema = z.object({
    email: z.string().min(1, 'Email is required').email('Email is invalid'),
});

const form = ref<Form<Schema>>();
type Schema = z.output<typeof schema>;

const state = reactive({
    email: '' as string | undefined,
});

const loading = ref(false);
const submitForm = async (event: FormSubmitEvent<Schema>) => {
    form.value!.clear();
    loading.value = true;

    try {
        await authStore.resetPassword(event.data);
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
</script>
