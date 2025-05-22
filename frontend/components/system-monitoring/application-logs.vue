<template>
    <u-table
        :columns="columns"
        :rows="logs"
        :loading-state="{
            icon: 'i-heroicons-arrow-path-20-solid',
            label: 'Loading...',
        }"
        :progress="{ color: 'blue', animation: 'carousel' }"
        class="w-full"
        :empty-state="{
            icon: 'material-symbols:info',
            label: 'No logs',
        }"
    />
</template>

<script lang="ts" setup>
import type { ApplicationLog } from '~/types/log';

const columns = [
    {
        key: 'date',
        label: 'Date',
        sortable: true,
    },
    {
        key: 'level',
        label: 'Level',
        sortable: true,
    },
    {
        key: 'message',
        label: 'Message',
    },
];

const { $notify } = useNuxtApp();

const logs = ref<ApplicationLog[]>([]);
const errorCount = ref(0);

onMounted(async () => {
    const { data, meta } = await apiFetch<{
        data: ApplicationLog[];
        meta: { total: { errors: number } };
    }>('v1/logs/app');

    logs.value = data;
    errorCount.value = meta.total.errors;

    window.addEventListener('app-logs:clear', async () => {
        try {
            await apiFetch('v1/logs/app', {
                method: 'DELETE',
            });

            $notify('Logs cleared successfully', 'success');
            logs.value = [];
            errorCount.value = 0;
        } catch (error) {
            console.error(error);

            $notify('Error clearing logs', 'error');
        }
    });
});
</script>
