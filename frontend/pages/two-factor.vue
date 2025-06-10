<template>
    <div class="space-y-6">
        <auth-form-header
            title="Two-Factor Authentication"
            subtitle="Please enter the code from your authenticator application"
        />

        <u-form :state="state" class="space-y-6" @submit="submitForm">
            <u-form-field size="lg" name="code" required>
                <div class="flex justify-center gap-4">
                    <u-input
                        v-for="(digit, index) in state"
                        :id="'code_input_' + index"
                        :key="index"
                        v-model="state[index]"
                        class="content-center w-12 h-16 text-lg font-bold border border-gray-600 rounded-lg shadow-xl bg-gray-80 hover:ring-1 focus:outline-hidden focus:ring-2 focus:ring-gray-500"
                        variant="none"
                        block
                        required
                        size="xl"
                        name="code"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="1"
                        @input="handleInput(index)"
                        @keydown="handleKeydown(index, $event)"
                    />
                </div>
            </u-form-field>

            <div class="flex justify-center gap-4">
                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-hidden focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    label="Confirm"
                    block
                    type="submit"
                    icon="material-symbols:login-rounded"
                />

                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-hidden focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
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
    middleware: [
        function (to, from) {
            if (from.path !== '/login') {
                return navigateTo('/login');
            }
        },
    ],
});

onMounted(() => {
    document.getElementById('code_input_0').focus();
});

const authStore = useAuthStore();
const state = reactive(['', '', '', '', '', '']);

const submitForm = async () => {
    if (state.join('').length === 6) {
        await authStore.confirmTwoFactorCode(state.join(''));
    } else {
        $notify('Please enter all digits of the code.', 'error');
    }
};

function handleInput(index) {
    if (index < 5) {
        document.getElementById('code_input_' + (index + 1)).focus();
    }
}

function handleKeydown(index, event) {
    const currentElement = document.getElementById('code_input_' + index);

    if (event.key === 'Backspace' && index > 0 && !currentElement.value) {
        document.getElementById('code_input_' + (index - 1)).focus();
    }
}
</script>
