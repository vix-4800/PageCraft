<!-- components/ConfirmModal.vue -->
<template>
    <u-modal>
        <u-card>
            <template #header>
                <h3 class="text-lg font-semibold">
                    {{ title }}
                </h3>

                <p class="text-sm text-gray-600">
                    {{ message }}
                </p>
            </template>

            <u-form
                ref="form"
                :state="state"
                :schema="schema"
                @submit="confirm"
            >
                <u-form-group label="Password" name="password" required>
                    <u-input
                        v-model="state.password"
                        color="blue"
                        size="md"
                        type="password"
                        label="Password"
                    />
                </u-form-group>

                <div class="flex justify-end gap-2 mt-4">
                    <u-button
                        size="md"
                        icon="material-symbols:send"
                        color="blue"
                        label="Confirm"
                        :loading="loading"
                        type="submit"
                    />
                </div>
            </u-form>
        </u-card>
    </u-modal>
</template>

<script lang="ts" setup>
import { z } from 'zod';
import type { FormSubmitEvent, Form } from '#ui/types';

const { title, message, successNotificationMessage, successFunction } =
    defineProps({
        title: {
            type: String,
            required: true,
        },
        message: {
            type: String,
            required: true,
        },
        successNotificationMessage: {
            type: String,
            required: false,
            default: '',
        },
        successFunction: {
            type: Function,
            required: true,
        },
    });

const schema = z.object({
    password: z.string().min(1, 'Password is required'),
});

interface Schema {
    password?: string;
}

const form = ref<Form<Schema>>();
const state = reactive({
    password: '' as string,
});

const modal = useModal();
const { $notify } = useNuxtApp();
const authStore = useAuthStore();

const loading = ref(false);

const confirm = async (event: FormSubmitEvent<Schema>) => {
    form.value!.clear();
    loading.value = true;

    try {
        await authStore.confirmPassword(event.data.password);

        modal.close();

        await successFunction();

        if (successNotificationMessage)
            $notify(successNotificationMessage, 'success');
    } catch (err) {
        if (err.data.errors.password) {
            form.value!.setErrors([
                {
                    path: 'password',
                    message: err.data.errors.password[0],
                },
            ]);
        }
    } finally {
        loading.value = false;
    }
};
</script>
