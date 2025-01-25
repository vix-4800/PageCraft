<template>
    <div>
        <dashboard-page-name title="Account" />

        <div class="space-y-4">
            <u-card :ui="{ background: 'bg-slate-100' }">
                <template #header>
                    <h3 class="text-lg font-semibold">Update Profile Info</h3>
                </template>

                <u-form
                    :schema="profileSchema"
                    :state="profileState"
                    class="space-y-4"
                    @submit="updateProfile"
                >
                    <u-form-group label="Name" name="name">
                        <u-input
                            v-model="profileState.name"
                            icon="material-symbols:person"
                            placeholder="Name"
                            color="blue"
                            size="lg"
                        />
                    </u-form-group>

                    <u-form-group label="Email" name="email">
                        <u-input
                            v-model="profileState.email"
                            icon="material-symbols:mail"
                            color="blue"
                            placeholder="Email"
                            type="email"
                            size="lg"
                        />
                    </u-form-group>

                    <u-form-group label="Phone" name="phone">
                        <u-input
                            v-model="profileState.phone"
                            icon="material-symbols:phone-enabled"
                            color="blue"
                            placeholder="Phone"
                            size="lg"
                        />
                    </u-form-group>

                    <u-button
                        color="blue"
                        size="md"
                        label="Submit"
                        icon="material-symbols:save"
                        type="submit"
                    />
                </u-form>
            </u-card>

            <u-card :ui="{ background: 'bg-slate-100' }">
                <template #header>
                    <h3 class="text-lg font-semibold">Update Password</h3>
                </template>

                <u-form
                    ref="passwordForm"
                    :schema="passwordSchema"
                    :state="passwordState"
                    :validate="validatePassword"
                    class="space-y-4"
                    @submit="updatePassword"
                >
                    <u-form-group
                        label="Current Password"
                        name="current_password"
                    >
                        <u-input
                            v-model="passwordState.current_password"
                            icon="material-symbols:lock"
                            type="password"
                            placeholder="Current password"
                            color="blue"
                            size="lg"
                        />
                    </u-form-group>

                    <u-form-group label="New Password" name="password">
                        <u-input
                            v-model="passwordState.password"
                            icon="material-symbols:lock"
                            type="password"
                            placeholder="New password"
                            color="blue"
                            size="lg"
                        />
                    </u-form-group>

                    <u-form-group
                        label="Confirm New Password"
                        name="password_confirmation"
                    >
                        <u-input
                            v-model="passwordState.password_confirmation"
                            icon="material-symbols:lock"
                            type="password"
                            placeholder="Confirm new password"
                            color="blue"
                            size="lg"
                        />
                    </u-form-group>

                    <u-button
                        color="blue"
                        size="md"
                        label="Submit"
                        icon="material-symbols:save"
                        type="submit"
                    />
                </u-form>
            </u-card>

            <u-card :ui="{ background: 'bg-slate-100' }">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold">
                        Two Factor Authentication
                    </h3>

                    <div class="flex gap-2">
                        <u-button
                            v-if="authStore.user?.two_factor.enabled"
                            color="blue"
                            size="md"
                            label="View QR Code"
                            icon="mdi:qrcode"
                            @click="showQrCode"
                        />

                        <u-button
                            :color="
                                authStore.user?.two_factor.enabled
                                    ? 'red'
                                    : 'blue'
                            "
                            size="md"
                            :label="
                                authStore.user?.two_factor.enabled
                                    ? 'Disable'
                                    : 'Enable'
                            "
                            :icon="
                                authStore.user?.two_factor.enabled
                                    ? 'mdi:close'
                                    : 'mdi:check'
                            "
                            @click="toggleTwoFactor"
                        />
                    </div>
                </div>
            </u-card>

            <u-card :ui="{ background: 'bg-red-100' }">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold">Delete Account</h3>

                    <div class="flex gap-2">
                        <u-button
                            color="red"
                            size="md"
                            label="Delete"
                            icon="material-symbols:delete"
                            @click="deleteAccount"
                        />
                    </div>
                </div>
            </u-card>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { z } from 'zod';
import type { FormSubmitEvent, Form, FormError } from '#ui/types';
import TwoFactor from '~/components/modals/two-factor.vue';

definePageMeta({
    layout: 'dashboard',
    middleware: ['verified'],
});

const authStore = useAuthStore();

type Schema = z.output<typeof profileSchema>;
const profileState = reactive({
    name: '' as string | undefined,
    email: '' as string | undefined,
    phone: '' as string | undefined,
});

const profileSchema = z.object({
    name: z
        .string()
        .min(1, 'Name is required')
        .min(2, 'Must be at least 2 characters'),
    email: z.string().min(1, 'Email is required').email('Invalid email'),
    phone: z
        .string()
        .min(1, 'Phone is required')
        .min(8, 'Must be at least 8 characters'),
});

onMounted(async () => {
    profileState.name = authStore.user?.name;
    profileState.email = authStore.user?.email;
    profileState.phone = authStore.user?.phone;
});

const { $notify } = useNuxtApp();
const updateProfile = async (event: FormSubmitEvent<Schema>) => {
    await authStore.update(event.data);
    await authStore.fetchUser();

    $notify('Account updated successfully', 'success');
};

const passwordForm = ref<Form<Schema>>();
type PasswordSchema = z.output<typeof passwordSchema>;
const passwordState = reactive({
    current_password: '' as string | undefined,
    password: '' as string | undefined,
    password_confirmation: '' as string | undefined,
});
const passwordSchema = z.object({
    current_password: z.string().min(1, 'Current password is required'),
    password: z
        .string()
        .min(1, 'Password is required')
        .min(8, 'Must be at least 8 characters'),
    password_confirmation: z
        .string()
        .min(1, 'Password is required')
        .min(8, 'Must be at least 8 characters'),
});
const updatePassword = async (event: FormSubmitEvent<PasswordSchema>) => {
    passwordForm.value!.clear();

    try {
        await authStore.updatePassword(event.data);

        $notify('Password updated successfully', 'success');

        passwordState.current_password = '';
        passwordState.password = '';
        passwordState.password_confirmation = '';
    } catch (error) {
        if (error?.statusCode === 422) {
            passwordForm.value!.setErrors([
                {
                    path: 'current_password',
                    message: error.data.message,
                },
            ]);
        }
    }
};
const validatePassword = (passwordState: Schema): FormError[] => {
    const errors = [];

    if (passwordState.password !== passwordState.password_confirmation) {
        errors.push({
            path: 'password_confirmation',
            message: 'Passwords do not match',
        });
    }

    return errors;
};

const modal = useModal();
async function showQrCode() {
    const qrCode = await authStore.fetchTwoFactorQrCode();
    const recoveryCodes = await authStore.fetchTwoFactorRecoveryCodes();

    modal.open(TwoFactor, {
        qrCode,
        recoveryCodes,
    });
}

async function toggleTwoFactor() {
    await authStore.toggleTwoFactor();

    if (authStore.user?.two_factor.enabled) await showQrCode();
}

const deleteAccount = async () => {
    await authStore.deleteUser();
};
</script>
