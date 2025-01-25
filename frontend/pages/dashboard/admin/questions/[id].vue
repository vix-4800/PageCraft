<template>
    <div>
        <dashboard-page-name
            title="User Question"
            :subtitle="`#${question?.id || ''}`"
            :description="`Created on ${question?.created_at || ''}`"
        >
            <template #actions>
                <u-button
                    :to="`mailto:${question?.email}`"
                    label="Reply"
                    size="md"
                    color="blue"
                    icon="mdi:reply"
                />
            </template>
        </dashboard-page-name>

        <div v-if="question" class="space-y-2">
            <div>
                <h4 class="text-lg font-bold text-gray-800">User</h4>
                <p class="text-gray-600">
                    <span class="font-bold">Email:</span>
                    {{ question.email }}
                </p>
                <p class="text-gray-600">
                    <span class="font-bold">Phone:</span>
                    {{ question.phone }}
                </p>
            </div>

            <div>
                <h4 class="text-lg font-bold text-gray-800">Question</h4>
                <p class="text-gray-600">
                    {{ question.message }}
                </p>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { FeedbackQuestion } from '~/types/feedback_question';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

const route = useRoute();
const question = ref<FeedbackQuestion | null>(null);

onMounted(async () => {
    const { data } = await apiFetch<{ data: FeedbackQuestion }>(
        `v1/feedback/questions/${route.params.id}`
    );

    question.value = data;
});
</script>
