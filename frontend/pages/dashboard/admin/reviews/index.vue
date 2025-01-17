<template>
    <div>
        <DashboardPageName title="Reviews" />

        <div>
            <h2 class="mb-6 text-xl font-extrabold text-gray-800">Pending</h2>
            <u-table
                :columns="columns"
                :rows="pendingReviews"
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
        </div>

        <div class="mt-12">
            <h2 class="mb-6 text-xl font-extrabold text-gray-800">All</h2>
            <u-table
                :columns="columns"
                :rows="reviews"
                :loading="status === 'pending'"
                :loading-state="{
                    icon: 'i-heroicons-arrow-path-20-solid',
                    label: 'Loading...',
                }"
                :progress="{ color: 'blue', animation: 'carousel' }"
                class="w-full"
                :empty-state="{
                    icon: 'material-symbols:rate-review',
                    label: 'No reviews',
                }"
                @select="select"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Review } from '~/types/review';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

const columns = [
    {
        key: 'id',
        label: 'ID',
        sortable: true,
    },
    {
        key: 'user.name',
        label: 'User',
        sortable: true,
    },
    {
        key: 'product.name',
        label: 'Product',
        sortable: true,
    },
    {
        key: 'rating',
        label: 'Rating',
        sortable: true,
    },
    {
        key: 'created_at',
        label: 'Date',
        sortable: true,
    },
];

const reviews = ref<Review[]>([]);
const status = ref('pending');
async function getReviews() {
    const { data } = await apiFetch<{ data: Review[] }>('v1/reviews');

    reviews.value = data;
}

const pendingReviews = ref<Review[]>([]);
async function getPendingReviews() {
    const { data } = await apiFetch<{ data: Review[] }>('v1/reviews/pending');

    pendingReviews.value = data;
}

onMounted(async () => {
    await getReviews();
    await getPendingReviews();

    status.value = 'success';
});

function select(row: Review) {
    return navigateTo('/dashboard/admin/reviews/' + row.id);
}
</script>
