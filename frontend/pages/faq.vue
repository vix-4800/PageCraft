<template>
    <div>
        <page-title
            title="Часто задаваемые вопросы"
            subtitle="Ответы на самые частые запросы"
        />

        <u-accordion
            :items="questions"
            size="xl"
            variant="ghost"
            color="white"
            open-icon="material-symbols:expand-more-rounded"
            close-icon="material-symbols:expand-less-rounded"
        />
    </div>
</template>

<script lang="ts" setup>
import type { Faq } from '~/types/faq';

const questions = ref<Faq[]>();

onMounted(async () => {
    const { data } = await apiFetch<{ data: Faq[] }>(`v1/faq`);

    questions.value = data;
});
</script>
