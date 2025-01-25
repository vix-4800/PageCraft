<template>
    <div>
        <dashboard-page-name title="Review" :subtitle="`#${review?.id}`">
            <template #actions>
                <u-button
                    v-if="review?.status === ReviewStatus.PENDING"
                    label="Approve"
                    icon="material-symbols:verified"
                    color="blue"
                    size="md"
                    @click="updateReviewStatus(ReviewStatus.APPROVED)"
                />

                <u-button
                    v-if="review?.status === ReviewStatus.PENDING"
                    label="Reject"
                    icon="material-symbols:block"
                    color="red"
                    size="md"
                    @click="updateReviewStatus(ReviewStatus.REJECTED)"
                />
            </template>
        </dashboard-page-name>

        <div v-if="review">
            <div class="flex justify-between">
                <div>
                    <h4 class="font-bold text-gray-800">
                        User: {{ review?.user?.name }}
                    </h4>
                    <p class="text-gray-500">
                        Product: {{ review?.product?.name }}
                    </p>
                </div>
                <div class="flex items-center mt-1">
                    <u-icon
                        v-for="i in review?.rating"
                        :key="i"
                        name="line-md:star-alt-filled"
                        size="20"
                        class="bg-orange-400"
                    />
                    <u-icon
                        v-for="i in 5 - review?.rating"
                        :key="i"
                        name="line-md:star-alt-filled"
                        size="20"
                        class="bg-gray-400"
                    />
                </div>
            </div>
            <p class="mt-2 text-gray-500">
                {{ review?.text }}
            </p>
        </div>
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

const updateReviewStatus = async (status: ReviewStatus) => {
    const { data } = await apiFetch<{ data: Review }>(
        `v1/reviews/${route.params.id}`,
        {
            method: 'PATCH',
            body: {
                status,
            },
        }
    );

    review.value = data;
    $notify('Review updated successfully', 'success');
};
</script>
