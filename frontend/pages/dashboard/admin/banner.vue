<template>
    <div>
        <dashboard-page-name title="Banner" />

        <u-form
            v-if="banner"
            ref="form"
            :schema="schema"
            :state="banner"
            class="space-y-4"
            @submit="save"
        >
            <u-form-group label="Text" name="text">
                <u-input
                    v-model="banner.text"
                    placeholder="Banner text"
                    color="blue"
                    size="md"
                />
            </u-form-group>

            <u-form-group label="Link" name="link">
                <u-input
                    v-model="banner.link"
                    placeholder="Banner link"
                    color="blue"
                    size="md"
                />
            </u-form-group>

            <u-form-group label="Is Banner Active" name="is_active">
                <u-toggle
                    v-model="banner.is_active"
                    color="blue"
                    size="lg"
                    on-icon="material-symbols:check"
                    off-icon="material-symbols:close"
                />
            </u-form-group>

            <u-button
                type="submit"
                color="blue"
                icon="material-symbols:save"
                size="md"
                label="Save"
            />
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import { z } from 'zod';
import type { FormSubmitEvent, Form } from '#ui/types';
import type { Banner } from '~/types/banner';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const loading = ref(false);
const banner = ref<Banner>();
const { $notify } = useNuxtApp();

const schema = z.object({
    text: z.string().min(1, 'Banner text is required'),
    link: z.union([z.string().url().nullish(), z.literal('')]),
    is_active: z.boolean(),
});

const form = ref<Form<Schema>>();
type Schema = z.output<typeof schema>;

onMounted(async () => {
    loading.value = true;

    const { data } = await apiFetch<{ data: Banner }>(`v1/banners`);

    banner.value = data;
    loading.value = false;
});

const save = async (event: FormSubmitEvent<Schema>) => {
    loading.value = true;

    try {
        const { data } = await apiFetch('v1/banners', {
            method: 'PUT',
            body: event.data,
        });

        banner.value = data;
        $notify('Banner updated successfully', 'success');
    } catch (error) {
        if (error?.statusCode === 422) {
            form.value!.setErrors([
                {
                    path: 'text',
                    message: error.data.errors.text[0],
                },
            ]);
        }
    } finally {
        loading.value = false;
    }
};
</script>
