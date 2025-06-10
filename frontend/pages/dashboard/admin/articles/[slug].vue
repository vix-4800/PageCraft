<template>
    <div v-if="article">
        <dashboard-page-name
            title="Article"
            :subtitle="article?.slug || ''"
            :description="`Created on ${article?.created_at || ''}`"
        />

        <u-form
            :state="article"
            :schema="schema"
            class="space-y-4"
            @submit="save"
        >
            <div class="flex w-full gap-4">
                <u-form-field label="Title" name="title" class="w-1/2">
                    <u-input v-model="article.title" color="blue" />
                </u-form-field>

                <u-form-field label="Author" name="author" class="w-1/2">
                    <u-input v-model="article.author" color="blue" />
                </u-form-field>
            </div>

            <u-form-field label="Description" name="description">
                <u-textarea v-model="article.description" color="blue" />
            </u-form-field>

            <tiptap-editor v-model="article.content" />

            <u-button
                color="blue"
                size="md"
                label="Save"
                icon="material-symbols:save"
                type="submit"
            />
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import { z } from 'zod';
import type { FormSubmitEvent } from '#ui/types';
import type { Article } from '~/types/article';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const { $notify } = useNuxtApp();
const route = useRoute();

const article = ref<Article>();
const loading = ref(false);

onMounted(async () => {
    loading.value = true;

    const { data } = await apiFetch<{ data: Article }>(
        `v1/articles/${route.params.slug}`
    );

    article.value = data;
    loading.value = false;
});

const schema = z.object({
    title: z.string().min(1, 'Title is required'),
    content: z.string().min(1, 'Content is required'),
    author: z.string().min(1, 'Content is required'),
    description: z.string().min(1, 'Description is required'),
});

type Schema = z.output<typeof schema>;

const save = async (event: FormSubmitEvent<Schema>) => {
    loading.value = true;

    await apiFetch(`v1/articles/${route.params.slug}`, {
        method: 'PUT',
        body: event.data,
    });

    $notify('Marketplace account updated successfully', 'success');
    loading.value = false;
};
</script>
