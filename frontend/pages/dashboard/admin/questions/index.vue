<template>
    <div>
        <dashboard-page-name title="User Questions" />

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
                icon: 'material-symbols:question-mark',
                label: 'No questions',
            }"
            @select="select"
        />

        <div
            v-if="total > 10"
            class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
        >
            <u-pagination
                v-model="page"
                :active-button="{ variant: 'outline', color: 'blue' }"
                :inactive-button="{ color: 'gray' }"
                :total="total"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { FeedbackQuestion } from '~/types/feedback_question';
import type { Meta } from '~/types/pagination';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const columns = [
    {
        key: 'id',
        label: 'ID',
        sortable: true,
    },
    {
        key: 'email',
        label: 'Email',
        sortable: true,
    },
    {
        key: 'phone',
        label: 'Phone',
    },
    {
        key: 'created_at',
        label: 'Date',
        sortable: true,
    },
];

const status = ref('pending');
const questions = ref<FeedbackQuestion[]>([]);
const page = ref(1);
const total = ref(0);

onMounted(async () => {
    await getQuestions();
});

watch(page, async () => {
    await getQuestions();
});

const getQuestions = async () => {
    const { data, meta } = await apiFetch<{
        data: FeedbackQuestion[];
        meta: Meta;
    }>('v1/feedback/messages', {
        params: {
            page: page.value,
        },
    });

    questions.value = data;
    page.value = meta.current_page;
    total.value = meta.total;

    status.value = 'success';
};

function select(row: FeedbackQuestion) {
    return navigateTo('/dashboard/admin/questions/' + row.id);
}
</script>
