<template>
    <div class="border rounded-xl border-slate-200 dark:border-0">
        <div v-if="loading" class="h-[400px] flex items-center justify-center">
            <div class="text-gray-500 dark:text-gray-400 animate-pulse">
                Loading dashboard...
            </div>
        </div>

        <div
            v-else-if="!isGrafanaAvailable"
            class="h-[400px] rounded-xl flex items-center justify-center bg-gray-50 dark:bg-gray-800"
        >
            <div class="text-center text-gray-500 dark:text-gray-400">
                <svg
                    class="w-12 h-12 mx-auto mb-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <p class="font-medium">Monitoring service unavailable</p>
                <p class="mt-1 text-sm">Please check Grafana configuration</p>
            </div>
        </div>

        <iframe
            v-else
            :src="url.toString()"
            class="w-full rounded-xl h-[400px] border border-slate-200 dark:border-0"
        ></iframe>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps({
    panelId: {
        type: Number,
        required: true,
    },
});

const loading = ref(true);
const isGrafanaAvailable = ref(false);

const url = new URL('http://localhost:3000/d-solo/rYdddlPWk/node-exporter');
url.searchParams.set('orgId', '1');
url.searchParams.set('timezone', 'browser');
url.searchParams.set('var-datasource', 'default');
url.searchParams.set('var-job', 'node_exporter');
url.searchParams.set('var-node', 'node-exporter:9100');
url.searchParams.set('panelId', props.panelId.toString());
url.searchParams.set('refresh', '30s');
url.searchParams.set('kiosk', 'tv');
url.searchParams.set('theme', useDark().value ? 'dark' : 'light');
url.searchParams.set('from', 'now-1h');
url.searchParams.set('to', 'now');

onMounted(async () => {
    try {
        const response = await fetch('http://localhost:3000/api/health');
        isGrafanaAvailable.value = response.ok;
    } catch (error) {
        console.error(error);
        isGrafanaAvailable.value = false;
    } finally {
        loading.value = false;
    }
});
</script>
