<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Account Settings</h2>
        </div>
        <div class="p-6 space-y-4">
            <u-card :ui="{ background: 'bg-slate-100' }">
                <template #header>
                    <h3 class="text-lg font-semibold">Profile Info</h3>
                </template>

                <u-form :state="user" class="space-y-4" @submit="submitForm">
                    <u-form-group label="Name" name="name">
                        <u-input
                            v-model="user.name"
                            color="blue"
                            size="lg"
                            required
                        />
                    </u-form-group>

                    <u-form-group label="Email" name="email">
                        <u-input
                            v-model="user.email"
                            color="blue"
                            size="lg"
                            required
                        />
                    </u-form-group>

                    <u-form-group label="Phone" name="phone">
                        <u-input
                            v-model="user.phone"
                            color="blue"
                            size="lg"
                            required
                        />
                    </u-form-group>

                    <u-form-group label="Password" name="password">
                        <u-input
                            v-model="user.password"
                            required
                            color="blue"
                            size="lg"
                            type="password"
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

            <u-modal v-model="isQrCodeModalOpen">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Two Factor QR Code</h3>

                    <p class="text-sm text-gray-600">
                        Scan the QR code below to enable two factor
                        authentication.
                    </p>

                    <div
                        v-html="qrCode"
                        class="flex items-center justify-center w-full h-56"
                    />

                    <u-divider class="my-4" />

                    <p class="mb-4 text-sm font-semibold text-gray-600">
                        If you lost your device, you can recover your account
                        using a recovery code.
                    </p>

                    <ul class="grid w-full grid-cols-2 gap-2">
                        <li
                            v-for="code in recoveryCodes"
                            :key="code"
                            class="text-sm text-gray-600"
                        >
                            <u-badge size="md" color="blue" variant="soft">
                                {{ code }}
                            </u-badge>
                        </li>
                    </ul>
                </div>
            </u-modal>

            <u-card :ui="{ background: 'bg-red-100' }">
                <template #header>
                    <h3 class="text-lg font-semibold">Delete Account</h3>
                </template>
            </u-card>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { User } from '~/types/user';

definePageMeta({
    layout: 'dashboard',
    middleware: [],
});

const authStore = useAuthStore();

const user = reactive({
    name: '' as string | undefined,
    email: '' as string | undefined,
    phone: '' as string | undefined,
    password: '',
});

onMounted(async () => {
    user.name = authStore.user?.name;
    user.email = authStore.user?.email;
    user.phone = authStore.user?.phone;
});

const { $notify } = useNuxtApp();
async function submitForm() {
    await apiFetch<{ data: User }>(`user`, {
        method: 'PATCH',
        body: JSON.stringify(user),
    });

    await authStore.fetchUser();
    user.password = '';

    $notify('Account updated successfully', 'success');
}

async function showQrCode() {
    isQrCodeModalOpen.value = true;
    qrCode.value = await authStore.fetchTwoFactorQrCode();
    recoveryCodes.value = await authStore.fetchTwoFactorRecoveryCodes();
}

async function toggleTwoFactor() {
    await authStore.toggleTwoFactor();

    if (authStore.user?.two_factor.enabled) await showQrCode();
}
const isQrCodeModalOpen = ref(false);
const qrCode = ref<null | string>(null);
const recoveryCodes = ref<null | string[]>(null);
</script>
