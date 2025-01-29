<template>
    <div>
        <auth-home-logo />

        <u-form
            ref="form"
            :state="credentials"
            :schema="schema"
            :validate="validate"
            class="space-y-4"
            @submit="submitForm"
        >
            <u-form-group size="lg" name="name">
                <u-input
                    v-model="credentials.name"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Name"
                    icon="material-symbols:person"
                />
            </u-form-group>

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

            <u-form-group size="lg" name="phone">
                <u-input
                    v-model="credentials.phone"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Phone"
                    icon="material-symbols:phone-enabled"
                />
            </u-form-group>

            <u-form-group size="lg" name="password">
                <u-input
                    v-model="credentials.password"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    type="password"
                    variant="none"
                    placeholder="Password"
                    icon="material-symbols:lock"
                />
            </u-form-group>

            <u-form-group size="lg" name="password_confirmation">
                <u-input
                    v-model="credentials.password_confirmation"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    type="password"
                    variant="none"
                    placeholder="Password confirmation"
                    icon="material-symbols:lock"
                />
            </u-form-group>

            <div class="flex justify-center gap-4">
                <u-button
                    class="text-gray-100 bg-gray-800 border border-gray-600 rounded-lg shadow-xl disabled:bg-gray-800 ring-0 w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-indigo-800 hover:ring-indigo-600 hover:bg-gray-700"
                    size="lg"
                    block
                    label="Register"
                    type="submit"
                    icon="material-symbols:person-add"
                    :loading="loading"
                    color="gray"
                />

                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    block
                    label="Login"
                    to="/login"
                    icon="material-symbols:login-rounded"
                />
            </div>
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import { z } from 'zod';
import type { FormError, FormSubmitEvent, Form } from '#ui/types';

definePageMeta({
    layout: 'auth',
    middleware: [
        function () {
            const authStore = useAuthStore();

            if (authStore.isAuthenticated) {
                return navigateTo(
                    `/dashboard/${authStore.isAdmin ? 'admin' : 'user'}`
                );
            }
        },
    ],
});

const authStore = useAuthStore();

const schema = z.object({
    name: z
        .string()
        .min(1, 'Name is required')
        .min(2, 'Must be at least 2 characters'),
    email: z.string().min(1, 'Email is required').email('Invalid email'),
    phone: z
        .string()
        .min(1, 'Phone is required')
        .min(8, 'Must be at least 8 characters'),
    password: z
        .string()
        .min(1, 'Password is required')
        .min(8, 'Must be at least 8 characters'),
    password_confirmation: z
        .string()
        .min(1, 'Password is required')
        .min(8, 'Must be at least 8 characters'),
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

const credentials = reactive({
    name: '' as string | undefined,
    email: '' as string | undefined,
    phone: '' as string | undefined,
    password: '' as string | undefined,
    password_confirmation: '' as string | undefined,
});

const form = ref<Form<Schema>>();
type Schema = z.output<typeof schema>;

const loading = ref(false);
const submitForm = async (event: FormSubmitEvent<Schema>) => {
    form.value!.clear();
    loading.value = true;

    try {
        await authStore.register(event.data);
    } catch (err) {
        if (err?.statusCode === 422) {
            form.value!.setErrors([
                {
                    path: 'name',
                    message: err.data.message,
                },
            ]);
        }
    } finally {
        loading.value = false;
    }
};
</script>
