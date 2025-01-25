<template>
    <div>
        <dashboard-page-name title="Reviews" />

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

            <div
                v-if="pendingReviewsTotal > 10"
                class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
            >
                <u-pagination
                    v-model="pendingReviewsPage"
                    :active-button="{ variant: 'outline', color: 'blue' }"
                    :inactive-button="{ color: 'gray' }"
                    :total="pendingReviewsTotal"
                />
            </div>
        </div>

        <div class="mt-12">
            <h2 class="mb-6 text-xl font-extrabold text-gray-800">All</h2>
            <u-table
                :columns="columns"
                :rows="allReviews"
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

            <div
                v-if="allReviewsTotal > 10"
                class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
            >
                <u-pagination
                    v-model="allReviewsPage"
                    :active-button="{ variant: 'outline', color: 'blue' }"
                    :inactive-button="{ color: 'gray' }"
                    :total="allReviewsTotal"
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Meta } from '~/types/pagination';
import { ReviewStatus, type Review } from '~/types/review';

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

const allReviews = ref<Review[]>([]);
const allReviewsPage = ref(1);
const allReviewsTotal = ref(0);
async function getReviews() {
    const { data, meta } = await apiFetch<{ data: Review[]; meta: Meta }>(
        'v1/reviews',
        {
            params: {
                page: allReviewsPage.value,
            },
        }
    );

    allReviews.value = data;
    allReviewsPage.value = meta.current_page;
    allReviewsTotal.value = meta.total;
}

const pendingReviews = ref<Review[]>([]);
const pendingReviewsPage = ref(1);
const pendingReviewsTotal = ref(0);
async function getPendingReviews() {
    const { data, meta } = await apiFetch<{ data: Review[]; meta: Meta }>(
        'v1/reviews',
        {
            params: {
                status: ReviewStatus.PENDING,
                page: pendingReviewsPage.value,
            },
        }
    );

    pendingReviews.value = data;
    pendingReviewsPage.value = meta.current_page;
    pendingReviewsTotal.value = meta.total;
}

const status = ref('pending');
onMounted(async () => {
    await getPendingReviews();
    await getReviews();

    status.value = 'success';
});

watch(pendingReviewsPage, async () => {
    await getPendingReviews();
});

watch(allReviewsPage, async () => {
    await getReviews();
});

function select(row: Review) {
    return navigateTo('/dashboard/admin/reviews/' + row.id);
}
</script>
