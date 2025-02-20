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
                src="http://localhost:3000/d-solo/rYdddlPWk/node-exporter?orgId=1&from=1740002938202&to=1740089338202&timezone=browser&var-datasource=default&var-job=node_exporter&var-node=node-exporter:9100&var-diskdevices=%5Ba-z%5D%2B%7Cnvme%5B0-9%5D%2Bn%5B0-9%5D%2B%7Cmmcblk%5B0-9%5D%2B&refresh=1m&kiosk=&theme=light&panelId=77&__feature.dashboardSceneSolo"
                class="w-full h-[400px] border rounded-xl border-slate-200 dark:border-0"
            ></iframe>

            <iframe
                src="http://localhost:3000/d-solo/rYdddlPWk/node-exporter?orgId=1&from=1740003195261&to=1740089595261&timezone=browser&var-datasource=default&var-job=node_exporter&var-node=node-exporter:9100&var-diskdevices=%5Ba-z%5D%2B%7Cnvme%5B0-9%5D%2Bn%5B0-9%5D%2B%7Cmmcblk%5B0-9%5D%2B&refresh=1m&kiosk=&theme=light&panelId=78&__feature.dashboardSceneSolo"
                class="w-full h-[400px] border rounded-xl border-slate-200 dark:border-0"
            ></iframe>

            <iframe
                src="http://localhost:3000/d-solo/rYdddlPWk/node-exporter?orgId=1&from=1740003087682&to=1740089487682&timezone=browser&var-datasource=default&var-job=node_exporter&var-node=node-exporter:9100&var-diskdevices=%5Ba-z%5D%2B%7Cnvme%5B0-9%5D%2Bn%5B0-9%5D%2B%7Cmmcblk%5B0-9%5D%2B&refresh=1m&kiosk=&theme=light&panelId=74&__feature.dashboardSceneSolo"
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

const lastUpdatedAt = ref(null);
const fetchMetrics = async () => {
    const { data } = await apiFetch<{ data: SystemReport[] }>('v1/reports');

    if (data.length > 0) {
        isDatabaseHealthy.value = data[data.length - 1].is_database_up;
        isCacheHealthy.value = data[data.length - 1].is_cache_up;

        uptime.value = data[data.length - 1].uptime;

        lastUpdatedAt.value = data[data.length - 1].collected_at;
    }
};
</script>
