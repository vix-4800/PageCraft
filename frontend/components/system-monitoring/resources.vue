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
            <grafana-widget
                v-for="id in [77, 78, 74]"
                :key="id"
                :panel-id="id"
            />
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

const fetchMetrics = async () => {
    const { data } = await apiFetch<{ data: SystemReport }>('v1/reports');

    isDatabaseHealthy.value = data.is_database_up;
    isCacheHealthy.value = data.is_cache_up;
    uptime.value = data.uptime;
};
</script>
