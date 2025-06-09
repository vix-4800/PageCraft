<template>
    <div>
        <dashboard-page-name title="FAQ">
            <template #actions>
                <u-button
                    color="blue"
                    size="md"
                    icon="material-symbols:add"
                    label="Create Question"
                    @click="navigateTo('/dashboard/admin/faq/create')"
                />
            </template>
        </dashboard-page-name>

        <u-table
            :columns="columns"
            :rows="questions"
            :loading="status === 'pending'"
            :loading-state="{
                icon: 'i-heroicons-arrow-path-20-solid',
                label: 'Loading...',
            }"
            :progress="{ color: 'blue', animation: 'carousel' }"
            class="w-full"
            :empty-state="{
                icon: 'material-symbols:rate-review',
                label: 'No frequently asked questions',
            }"
            @select="select"
        />
    </div>
</template>

<script lang="ts" setup>
import type { Faq } from '~/types/faq';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const columns = [
    {
        key: 'label',
        label: 'Label',
        sortable: true,
    },
    {
        key: 'content',
        label: 'Content',
        sortable: true,
    },
];

const questions = ref<Faq[]>([]);
const status = ref('pending');

onMounted(async () => {
    const { data } = await apiFetch<{ data: Faq[] }>(`v1/faq`);

    questions.value = data;
    status.value = 'success';

    questions.value.forEach((product) => {
        product.label =
            product.label.length > 45
                ? `${product.label.slice(0, 45)}...`
                : product.label;

        product.content =
            product.content.length > 30
                ? `${product.content.slice(0, 30)}...`
                : product.content;
    });
});

function select(row: Faq) {
    return navigateTo('/dashboard/admin/faq');
}
</script>
