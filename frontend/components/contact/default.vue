<template>
    <div
        class="grid lg:grid-cols-3 items-start gap-4 p-2 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-lg"
    >
        <div class="bg-[#011c2b] rounded-lg p-6 h-full max-lg:order-1">
            <h2 class="text-xl text-white">Contact Information</h2>
            <p class="mt-4 text-sm text-gray-300">
                Have any question? We are here to help.
            </p>

            <ul class="mt-16 space-y-4">
                <li class="flex items-center">
                    <u-button
                        icon="material-symbols:mail"
                        variant="ghost"
                        to="mailto:info@example.com"
                        :label="settingsStore.getSetting(SettingKey.Email)"
                        class="text-white bg-transparent hover:bg-transparent hover:text-blue-300"
                    />
                </li>
                <li class="flex items-center">
                    <u-button
                        to="tel:158996888"
                        icon="material-symbols:phone-enabled"
                        :label="settingsStore.getSetting(SettingKey.Phone)"
                        variant="ghost"
                        class="text-white bg-transparent hover:bg-transparent hover:text-blue-300"
                    />
                </li>
                <li class="flex items-center">
                    <u-button
                        icon="material-symbols:location-on"
                        variant="ghost"
                        :label="settingsStore.getSetting(SettingKey.Address)"
                        class="text-white bg-transparent hover:bg-transparent hover:text-blue-300"
                    />
                </li>
            </ul>

            <ul class="flex flex-wrap gap-4 mt-16">
                <li
                    v-for="socialLink in settingsStore.getSocialLinks()"
                    :key="socialLink.key"
                >
                    <u-button
                        :to="socialLink.value"
                        :icon="socialLink.icon"
                        :ui="{ rounded: 'rounded-full' }"
                        target="_blank"
                        color="blue"
                    />
                </li>
            </ul>
        </div>

        <div class="p-4 lg:col-span-2">
            <u-form :state="state" :schema="schema" @submit="submitForm">
                <div class="grid gap-4 sm:grid-cols-2">
                    <u-form-group label="Email" name="email">
                        <u-input
                            v-model="state.email"
                            icon="material-symbols:mail"
                            type="email"
                            placeholder="Email"
                            color="blue"
                            size="lg"
                            :disabled="loading"
                        />
                    </u-form-group>

                    <u-form-group label="Phone Number" name="phone">
                        <u-input
                            v-model="state.phone"
                            icon="material-symbols:phone-enabled"
                            type="tel"
                            placeholder="Phone Number"
                            color="blue"
                            size="lg"
                            :disabled="loading"
                        />
                    </u-form-group>

                    <u-form-group
                        label="Message"
                        name="message"
                        class="w-full col-span-full"
                    >
                        <u-textarea
                            v-model="state.message"
                            placeholder="Message"
                            color="blue"
                            :maxrows="5"
                            autoresize
                            :disabled="loading"
                        />
                    </u-form-group>

                    <u-form-group name="subject" class="col-span-full">
                        <u-radio-group
                            v-model="state.subject"
                            legend="Select Subject"
                            :options="subjects"
                            color="blue"
                            :disabled="loading"
                        />
                    </u-form-group>
                </div>

                <u-button
                    type="submit"
                    color="blue"
                    :disabled="loading"
                    icon="material-symbols:send"
                    label="Send Message"
                    class="flex items-center justify-center px-4 py-3 mt-12 text-sm tracking-wide text-white bg-blue-600 rounded-lg lg:ml-auto max-lg:w-full hover:bg-blue-700"
                />
            </u-form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { z } from 'zod';
import type { FormSubmitEvent } from '#ui/types';
import { SettingKey } from '~/types/site_setting';

const authStore = useAuthStore();
const { $notify } = useNuxtApp();
const settingsStore = useSiteSettingsStore();

const loading = ref(false);
const subjects = [
    { label: 'General', value: 'general' },
    { label: 'Support', value: 'support' },
    { label: 'Other', value: 'other' },
];

const state = reactive({
    email: authStore.isAuthenticated ? authStore.user?.email : '',
    phone: authStore.isAuthenticated ? authStore.user?.phone : '',
    message: '',
    subject: subjects[0].value,
});

type Schema = z.output<typeof schema>;

const schema = z.object({
    email: z.string().min(1, 'Email is required').email('Invalid email'),
    phone: z.string().nullable(),
    message: z
        .string()
        .min(1, 'Message is required')
        .min(8, 'Must be at least 8 characters'),
    subject: z.string().min(1, 'Subject is required'),
});

const submitForm = async (event: FormSubmitEvent<Schema>) => {
    loading.value = true;

    try {
        await apiFetch('v1/feedback/messages', {
            method: 'POST',
            body: event.data,
        });

        $notify('Message sent successfully', 'success');
    } catch (error) {
        console.error(error);

        $notify('Error sending message', 'error');
    } finally {
        loading.value = false;
    }
};
</script>
