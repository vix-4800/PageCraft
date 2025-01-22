<template>
    <u-modal>
        <u-card>
            <template #header>
                <h3 class="text-lg font-semibold">Two Factor QR Code</h3>

                <p class="text-sm text-gray-600">
                    Scan the QR code below to enable two factor authentication.
                </p>
            </template>

            <div
                class="flex items-center justify-center w-full h-56"
                v-html="qrCode"
            />

            <u-divider class="my-4" />

            <p class="mb-4 text-sm font-semibold text-gray-600">
                If you lost your device, you can recover your account using a
                recovery code.
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
        </u-card>
    </u-modal>
</template>

<script lang="ts" setup>
defineProps({
    qrCode: {
        type: String,
        required: true,
    },
    recoveryCodes: {
        type: Array as () => string[],
        required: true,
    },
});
</script>
