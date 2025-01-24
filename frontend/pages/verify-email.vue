<template>
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-center">Verify Email</h1>

        <p class="text-center">
            Please follow the link sent to your email address (
            <span class="font-bold text-slate-100">
                {{ authStore.user?.email }}
            </span>
            ) to verify your email
        </p>
        <div class="flex justify-center gap-4">
            <u-button
                class="text-gray-100 bg-gray-800 border border-gray-600 rounded-lg shadow-xl disabled:bg-gray-800 ring-0 w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-indigo-800 hover:ring-indigo-600 hover:bg-gray-700"
                size="lg"
                label="Resend"
                block
                :loading="loading"
                icon="material-symbols:refresh"
                color="gray"
                @click="resendCode"
            />

            <u-button
                class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                size="lg"
                label="Logout"
                block
                icon="material-symbols:logout-rounded"
                @click="authStore.logout()"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'auth',
    middleware: [
        function () {
            const authStore = useAuthStore();

            if (!authStore.isAuthenticated) {
                return navigateTo('/login');
            } else if (authStore.isVerified) {
                return navigateTo(
                    `/dashboard/${authStore.isAdmin ? 'admin' : 'user'}`
                );
            }
        },
    ],
});

const authStore = useAuthStore();
const loading = ref(false);
const { $notify } = useNuxtApp();

const resendCode = async () => {
    loading.value = true;

    await authStore.resendVerificationEmail();

    $notify('New verification email sent', 'success');
    loading.value = false;
};

const route = useRoute();
onMounted(async () => {
    if (route.query.verify_url !== undefined) {
        const url = new URL(route.query.verify_url as string);

        await authStore.verifyEmail(url.pathname.replace('/api/', ''));
    }
});
</script>
