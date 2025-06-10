<template>
    <div>
        <auth-home-logo />

        <u-form
            ref="form"
            :state="state"
            :schema="schema"
            :validate="validate"
            class="space-y-4"
            @submit="submitForm"
        >
            <u-form-field size="lg" name="password">
                <u-input
                    v-model="state.password"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-hidden focus:ring-2 focus:ring-gray-500"
                    type="password"
                    variant="none"
                    placeholder="Password"
                    icon="material-symbols:lock"
                />
            </u-form-field>

            <u-form-field size="lg" name="password_confirmation">
                <u-input
                    v-model="state.password_confirmation"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-hidden focus:ring-2 focus:ring-gray-500"
                    type="password"
                    variant="none"
                    placeholder="Password confirmation"
                    icon="material-symbols:lock"
                />
            </u-form-field>

            <div class="flex justify-center">
                <u-button
                    class="text-gray-100 bg-gray-800 border border-gray-600 rounded-lg shadow-xl disabled:bg-gray-800 ring-0 hover:ring-1 te focus:outline-hidden focus:ring-2 focus:ring-indigo-800 hover:ring-indigo-600 hover:bg-gray-700"
                    size="lg"
                    label="Reset Password"
                    type="submit"
                    icon="material-symbols:lock-reset"
                    :loading="loading"
                    color="gray"
                />
            </div>
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import { z } from 'zod';
import type { FormSubmitEvent, Form, FormError } from '#ui/types';

definePageMeta({
    layout: 'auth',
});

const authStore = useAuthStore();
const { $notify } = useNuxtApp();
const route = useRoute();

const schema = z.object({
    password: z
        .string()
        .min(1, 'Password is required')
        .min(8, 'Must be at least 8 characters'),
    password_confirmation: z
        .string()
        .min(1, 'Password is required')
        .min(8, 'Must be at least 8 characters'),
});

const form = ref<Form<Schema>>();
type Schema = z.output<typeof schema>;

const state = reactive({
    password: '' as string | undefined,
    password_confirmation: '' as string | undefined,
});

const validate = (state: Schema): FormError[] => {
    const errors = [];

    if (state.password !== state.password_confirmation) {
        errors.push({
            path: 'password_confirmation',
            message: 'Passwords do not match',
        });
    }

    return errors;
};

const loading = ref(false);
const submitForm = async (event: FormSubmitEvent<Schema>) => {
    form.value!.clear();
    loading.value = true;

    try {
        const email = route.query.email as string;
        const token = route.query.token as string;

        await authStore.resetPassword(
            email,
            event.data.password,
            event.data.password_confirmation,
            token
        );

        $notify('Password reset successfully', 'success');
    } catch (err) {
        if (err?.statusCode === 422) {
            form.value!.setErrors([
                {
                    path: 'password',
                    message: err.data.message,
                },
            ]);
        }
    } finally {
        loading.value = false;
    }
};
</script>
