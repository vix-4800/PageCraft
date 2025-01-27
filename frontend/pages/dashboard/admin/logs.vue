<template>
    <div>
        <dashboard-page-name title="Application Logs" description="Latest logs">
            <template #actions>
                <u-button
                    v-if="logs.length > 0"
                    color="red"
                    size="md"
                    icon="material-symbols:delete"
                    :loading="deleting"
                    label="Clear"
                    @click="clearLogs"
                />
            </template>
        </dashboard-page-name>

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
                icon: 'material-symbols:info',
                label: 'No logs',
            }"
        />
    </div>
</template>

<script lang="ts" setup>
import type { Log } from '~/types/log';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
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

const { $notify } = useNuxtApp();

const loading = ref(false);
const logs = ref<Log[]>([]);
onMounted(async () => {
    loading.value = true;

    const { data } = await apiFetch<{ data: Log[] }>('v1/logs');

    logs.value = data;
    loading.value = false;
});

const deleting = ref(false);
const clearLogs = async () => {
    deleting.value = true;

    try {
        await apiFetch('v1/logs', {
            method: 'DELETE',
        });

        $notify('Logs cleared successfully', 'success');
        logs.value = [];
    } catch (error) {
        console.error(error);

        $notify('Error clearing logs', 'error');
    } finally {
        deleting.value = false;
    }
};
</script>
