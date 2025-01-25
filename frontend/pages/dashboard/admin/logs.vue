<template>
    <div>
        <dashboard-page-name
            title="Application Logs"
            description="Latest logs"
        />

        <u-table
            :columns="columns"
            :rows="logs"
            :loading="loading"
            :loading-state="{
                icon: 'i-heroicons-arrow-path-20-solid',
                label: 'Loading...',
            }"
            :progress="{ color: 'blue', animation: 'carousel' }"
            class="w-full"
            :empty-state="{
                icon: 'material-symbols:remove-shopping-cart',
                label: 'No logs',
            }"
        />
    </div>
</template>

<script lang="ts" setup>
import type { Log } from '~/types/log';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

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

const loading = ref(false);
const logs = ref<Log[]>([]);
onMounted(async () => {
    loading.value = true;
    const { data } = await apiFetch<{ data: Log[] }>('v1/logs');

    logs.value = data;
    loading.value = false;
});
</script>
