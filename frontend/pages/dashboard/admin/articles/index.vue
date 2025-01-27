<template>
    <div>
        <dashboard-page-name title="Articles">
            <template #actions>
                <u-button
                    label="Update Search Indexes"
                    icon="material-symbols:refresh"
                    color="blue"
                    size="md"
                    :loading="updatingIndexes"
                    @click="updateSearchIndexes"
                />

                <u-button
                    color="blue"
                    size="md"
                    icon="material-symbols:add"
                    label="Create Article"
                    @click="navigateTo('/dashboard/admin/articles/create')"
                />
            </template>
        </dashboard-page-name>

        <u-table
            :columns="columns"
            :rows="articles"
            :loading="status === 'pending'"
            :loading-state="{
                icon: 'i-heroicons-arrow-path-20-solid',
                label: 'Loading...',
            }"
            :progress="{ color: 'blue', animation: 'carousel' }"
            class="w-full"
            :empty-state="{
                icon: 'material-symbols:rate-review',
                label: 'No pending reviews',
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
import type { Meta } from '~/types/pagination';
import type { Article } from '~/types/article';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

const columns = [
    {
        key: 'title',
        label: 'Title',
        sortable: true,
    },
    {
        key: 'author',
        label: 'Author',
        sortable: true,
    },
    {
        key: 'status',
        label: 'Status',
        sortable: true,
    },
    {
        key: 'created_at',
        label: 'Date',
        sortable: true,
    },
];

const { $notify } = useNuxtApp();

const status = ref('pending');
const articles = ref();
const page = ref(1);
const total = ref(0);

onMounted(async () => {
    await getArticles();
});

watch(page, async () => {
    await getArticles();
});

const getArticles = async () => {
    status.value = 'pending';

    const { data, meta } = await apiFetch<{ data: Article[]; meta: Meta }>(
        'v1/articles',
        {
            params: {
                page: page.value,
            },
        }
    );

    articles.value = data;
    page.value = meta.current_page;
    total.value = meta.total;

    status.value = 'success';
};

function select(row: Article) {
    return navigateTo('/dashboard/admin/articles/' + row.slug);
}

const updatingIndexes = ref(false);
async function updateSearchIndexes() {
    updatingIndexes.value = true;

    await apiFetch(`v1/articles/update-search-indexes`, {
        method: 'POST',
    });

    updatingIndexes.value = false;
    $notify('Article Search Indexes Updated', 'success');
}
</script>
