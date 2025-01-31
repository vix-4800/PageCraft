<template>
    <div>
        <auth-form-header
            title="One-Time Password"
            :subtitle="
                codeSent
                    ? `Please enter the code from email`
                    : 'Please enter your email address to receive the code'
            "
        />

        <u-form
            v-if="codeSent"
            :state="verifyState"
            class="space-y-6"
            @submit="verifyCode"
        >
            <u-form-group size="lg" name="code" required>
                <div class="flex justify-center gap-4">
                    <u-input
                        v-for="(digit, index) in verifyState"
                        :id="'code_input_' + index"
                        :key="index"
                        v-model="verifyState[index]"
                        class="content-center w-12 h-16 text-lg font-bold border border-gray-600 rounded-lg shadow-xl bg-gray-80 hover:ring-1 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        variant="none"
                        block
                        required
                        size="xl"
                        name="code"
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

        <u-form
            v-else
            ref="form"
            :state="requestState"
            :schema="schema"
            class="space-y-4"
            @submit="sendOtp"
        >
            <u-form-group size="lg" name="email">
                <u-input
                    v-model="requestState.email"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Email"
                    type="email"
                    icon="material-symbols:mail"
                />
            </u-form-group>

            <div class="flex justify-center gap-4">
                <u-button
                    class="text-gray-100 bg-gray-800 border border-gray-600 rounded-lg shadow-xl disabled:bg-gray-800 ring-0 w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-indigo-800 hover:ring-indigo-600 hover:bg-gray-700"
                    size="lg"
                    label="Send Email"
                    block
                    type="submit"
                    icon="material-symbols:send"
                    :loading="sending"
                    color="gray"
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
import { z } from 'zod';
import type { FormSubmitEvent, Form } from '#ui/types';

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
const { $notify } = useNuxtApp();

const sending = ref(false);
const codeSent = ref(false);
const requestState = reactive({
    email: '' as string | undefined,
});
const schema = z.object({
    email: z.string().min(1, 'Email is required').email('Email is invalid'),
});
const form = ref<Form<Schema>>();
type Schema = z.output<typeof requestState>;

const verifyState = reactive(['', '', '', '', '', '']);

const handleInput = (index) => {
    if (codeSent.value) {
        const currentElement = document.getElementById('code_input_' + index);
        const value = currentElement.value.toUpperCase();
        currentElement.value = value;

        if (index < 5 && value) {
            document.getElementById('code_input_' + (index + 1)).focus();
        }
    }
};

const handleKeydown = (index, event) => {
    if (codeSent.value) {
        const currentElement = document.getElementById('code_input_' + index);

        if (event.key === 'Backspace' && index > 0 && !currentElement.value) {
            document.getElementById('code_input_' + (index - 1)).focus();
        }
    }
};

const sendOtp = async (event: FormSubmitEvent<Schema>) => {
    form.value!.clear();
    sending.value = true;

    try {
        await authStore.otpRequest(event.data.email);

        $notify('Code sent successfully', 'success');
        codeSent.value = true;
    } catch (err) {
        if (err?.statusCode === 422) {
            form.value!.setErrors([
                {
                    path: 'email',
                    message: err.data.message,
                },
            ]);
        }
    } finally {
        sending.value = false;
    }
};

watch(
    () => codeSent,
    async () => {
        if (codeSent.value) {
            await nextTick();
            document.getElementById('code_input_0').focus();
        }
    }
);

const verifyCode = async (event: FormSubmitEvent<Schema>) => {
    if (verifyState.join('').length === 6) {
        await authStore.otpVerify(event.data.email, verifyState.join(''));
    } else {
        $notify('Please enter all digits of the code.', 'error');
    }
};
</script>
