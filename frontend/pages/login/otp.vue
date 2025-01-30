<template>
    <div>
        <auth-form-header
            title="One-Time Password"
            subtitle="Please enter the code from email"
        />

        <u-form :state="state" class="space-y-6" @submit="submitForm">
            <u-form-group size="lg" name="code" required>
                <div class="flex justify-center gap-4">
                    <u-input
                        v-for="(digit, index) in state"
                        :id="'code_input_' + index"
                        :key="index"
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
                        @input="handleInput(index)"
                        @keydown="handleKeydown(index, $event)"
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
    middleware: [
        function (to, from) {
            if (from.path !== '/login') {
                return navigateTo('/login');
            }
        },
    ],
});

const authStore = useAuthStore();

onMounted(() => {
    document.getElementById('code_input_0').focus();
});

const state = reactive(['', '', '', '', '', '']);

const handleInput = (index) => {
    if (index < 5) {
        document.getElementById('code_input_' + (index + 1)).focus();
    }
};

const handleKeydown = (index, event) => {
    const currentElement = document.getElementById('code_input_' + index);

    if (event.key === 'Backspace' && index > 0 && !currentElement.value) {
        document.getElementById('code_input_' + (index - 1)).focus();
    }
};

const submitForm = async () => {
    if (state.join('').length === 6) {
        await authStore.otpVerify(state.join(''));
    } else {
        $notify('Please enter all digits of the code.', 'error');
    }
};
</script>
