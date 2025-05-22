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
            label: 'No queue logs',
        }"
    />
</template>

<script lang="ts" setup>
import type { QueueLog } from '~/types/log';

const columns = [
    {
        key: 'date',
        label: 'Date',
        sortable: true,
    },
    {
        key: 'name',
        label: 'Name',
    },
    {
        key: 'execution_time',
        label: 'Execution Time',
        sortable: true,
    },
    {
        key: 'status',
        label: 'Status',
        sortable: true,
    },
];

const { $notify } = useNuxtApp();

const logs = ref<QueueLog[]>([]);
onMounted(async () => {
    const { data } = await apiFetch<{ data: QueueLog[] }>('v1/logs/queue');

    logs.value = data;

    window.addEventListener('queue-logs:clear', async () => {
        try {
            await apiFetch('v1/logs/queue', {
                method: 'DELETE',
            });

            $notify('Logs cleared successfully', 'success');
            logs.value = [];
        } catch (error) {
            console.error(error);

            $notify('Error clearing logs', 'error');
        }
    });
});
</script>
