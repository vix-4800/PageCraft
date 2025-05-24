<template>
    <div>
        <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-9 md:gap-6">
            <card-mini
                label="Database Status"
                :value="isDatabaseHealthy ? 'Healthy' : 'Not Healthy'"
                :value-color="isDatabaseHealthy ? 'green-500' : 'red-500'"
            />

            <card-mini
                label="Cache Status"
                :value="isCacheHealthy ? 'Healthy' : 'Not Healthy'"
                :value-color="isCacheHealthy ? 'green-500' : 'red-500'"
            />

            <card-mini label="Uptime" :value="uptime" />
        </div>

        <div class="space-y-4">
            <iframe
                v-for="id in grafanaDashboardIds"
                :key="id"
                :src="grafanaUrl + '&panelId=' + id"
                class="w-full h-[400px] border rounded-xl border-slate-200 dark:border-0"
            ></iframe>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { SystemReport } from '~/types/system_report';

const loading = ref(false);
onMounted(async () => {
    loading.value = true;

    await fetchMetrics();

    loading.value = false;
});

const isDatabaseHealthy = ref(false);
const isCacheHealthy = ref(false);
const uptime = ref('');

const lastUpdatedAt = ref();
const fetchMetrics = async () => {
    const { data } = await apiFetch<{ data: SystemReport[] }>('v1/reports');

    if (data.length > 0) {
        isDatabaseHealthy.value = data[data.length - 1].is_database_up;
        isCacheHealthy.value = data[data.length - 1].is_cache_up;

        uptime.value = data[data.length - 1].uptime;

        lastUpdatedAt.value = data[data.length - 1].collected_at;
    }
};

const grafanaDashboardIds = [77, 78, 74];
const grafanaUrl = new URL(
    'http://localhost:3000/d-solo/rYdddlPWk/node-exporter'
);
grafanaUrl.searchParams.set('orgId', '1');
grafanaUrl.searchParams.set('timezone', 'browser');
grafanaUrl.searchParams.set('var-datasource', 'default');
grafanaUrl.searchParams.set('var-job', 'node_exporter');
grafanaUrl.searchParams.set('var-node', 'node-exporter:9100');
grafanaUrl.searchParams.set('refresh', '30s');
grafanaUrl.searchParams.set('kiosk', 'tv');
grafanaUrl.searchParams.set('theme', useDark().value ? 'dark' : 'light');
grafanaUrl.searchParams.set('from', 'now-1h');
grafanaUrl.searchParams.set('to', 'now');
</script>
