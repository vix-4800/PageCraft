<template>
    <div>
        <dashboard-page-name title="Review" :subtitle="`#${review?.id}`" />
    </div>
</template>

<script lang="ts" setup>
import { ReviewStatus, type Review } from '~/types/review';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

const review = ref<Review | null>(null);
const { $notify } = useNuxtApp();
const route = useRoute();

onMounted(async () => {
    const { data } = await apiFetch<{ data: Review }>(
        `v1/reviews/${route.params.id}`
    );

    review.value = data;
});
</script>
