<template>
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-center">
            Two-Factor Authentication
        </h1>

        <p class="text-center">
            Please enter the code from your authenticator application
        </p>

        <u-form :state="state" class="space-y-6" @submit="submitForm">
            <u-form-group size="lg" name="code" required>
                <div class="flex justify-center gap-4">
                    <u-input
                        v-for="(digit, index) in state"
                        :key="index"
                        ref="inputs"
                        v-model="state[index]"
                        class="content-center w-12 h-16 text-lg font-bold border border-gray-600 rounded-lg shadow-xl bg-gray-80 hover:ring-1 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        variant="none"
                        block
                        required
                        size="xl"
                        name="code"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="1"
                    />
                </div>
            </u-form-group>

            <div class="flex justify-center gap-4">
                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    label="Confirm"
                    block
                    type="submit"
                    icon="material-symbols:login-rounded"
                />

                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    label="Back"
                    block
                    to="/login"
                    icon="material-symbols:arrow-back"
                />
            </div>
        </u-form>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'auth',
});

const state = reactive(['', '', '', '', '', '']);
const inputs = ref([]);

const authStore = useAuthStore();
const submitForm = async () => {
    if (state.join('').length === 6) {
        await authStore.confirmTwoFactorCode(state.join(''));
    } else {
        alert('Please enter all digits of the code.');
    }
};
</script>
