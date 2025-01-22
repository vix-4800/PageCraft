<template>
    <div>
        <DashboardPageName title="Account" />

        <div class="space-y-4">
            <u-card :ui="{ background: 'bg-slate-100' }">
                <template #header>
                    <h3 class="text-lg font-semibold">Profile Info</h3>
                </template>

                <u-form
                    :schema="schema"
                    :state="user"
                    class="space-y-4"
                    @submit="submitForm"
                >
                    <u-form-group label="Name" name="name">
                        <u-input v-model="user.name" color="blue" size="lg" />
                    </u-form-group>

                    <u-form-group label="Email" name="email">
                        <u-input v-model="user.email" color="blue" size="lg" />
                    </u-form-group>

                    <u-form-group label="Phone" name="phone">
                        <u-input v-model="user.phone" color="blue" size="lg" />
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
import type { FormSubmitEvent } from '#ui/types';
import TwoFactor from '~/components/modals/two-factor.vue';

definePageMeta({
    layout: 'dashboard',
    middleware: ['verified'],
});

const authStore = useAuthStore();

const user = reactive({
    name: '' as string | undefined,
    email: '' as string | undefined,
    phone: '' as string | undefined,
});

type Schema = z.output<typeof schema>;
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
});

onMounted(async () => {
    user.name = authStore.user?.name;
    user.email = authStore.user?.email;
    user.phone = authStore.user?.phone;
});

const { $notify } = useNuxtApp();
async function submitForm(event: FormSubmitEvent<Schema>) {
    await authStore.update(event.data);
    await authStore.fetchUser();

    $notify('Account updated successfully', 'success');
}

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
