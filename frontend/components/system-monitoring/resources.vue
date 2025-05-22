<template>
    <div>
        <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-9 md:gap-6">
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

        <section id="cpu-metrics" class="h-96">
            <v-chart
                :option="cpuMetricsOption"
                :loading="loading"
                :autoresize="true"
            />
        </section>

        <section id="ram-metrics" class="h-96">
            <v-chart
                :option="ramMetricsOption"
                :loading="loading"
                :autoresize="true"
            />
        </section>

        <section id="network-metrics" class="h-96">
            <v-chart
                :option="networkMetricsOption"
                :loading="loading"
                :autoresize="true"
            />
        </section>
    </div>
</template>

<script lang="ts" setup>
import type { SystemReport } from '~/types/system_report';

const visualMap = {
    show: false,
    type: 'continuous',
    min: 0,
    max: 100,
    inRange: {
        colorAlpha: [0.25, 1],
        color: ['#00ff00', '#ffff00', '#ff0000'],
    },
};

const toolbox = {
    right: 10,
    feature: {
        saveAsImage: {},
    },
};

const tooltip = {
    trigger: 'axis',
};

const loading = ref(false);
const cpuMetricsOption = reactive<ECOption>({
    xAxis: {
        data: [],
        type: 'category',
        boundaryGap: false,
    },
    yAxis: {
        type: 'value',
        max: 100,
        min: 0,
    },
    series: {
        data: [],
        type: 'line',
        showSymbol: false,
        name: 'CPU Usage',
    },
    title: {
        left: 'center',
        text: 'CPU Usage (%)',
    },
    tooltip: tooltip,
    toolbox: toolbox,
    visualMap: visualMap,
    animationEasing: 'quadraticIn',
});

const ramMetricsOption = reactive<ECOption>({
    xAxis: {
        data: [],
        type: 'category',
        boundaryGap: false,
    },
    yAxis: {
        type: 'value',
        max: 100,
        min: 0,
    },
    series: {
        data: [],
        type: 'line',
        showSymbol: false,
        name: 'RAM Usage',
    },
    title: {
        left: 'center',
        text: 'RAM Usage (MB)',
    },
    tooltip: tooltip,
    toolbox: toolbox,
    visualMap: visualMap,
    animationEasing: 'quadraticIn',
});

const networkMetricsOption = reactive<ECOption>({
    xAxis: {
        data: [],
        type: 'category',
        boundaryGap: false,
    },
    yAxis: {
        type: 'value',
        min: 0,
    },
    series: [
        {
            data: [],
            type: 'line',
            showSymbol: false,
            name: 'Incoming',
            stack: 'Total',
        },
        {
            data: [],
            type: 'line',
            showSymbol: false,
            name: 'Outgoing',
            stack: 'Total',
        },
    ],
    title: {
        left: 'center',
        text: 'Network Usage (B)',
    },
    tooltip: tooltip,
    toolbox: toolbox,
    animationEasing: 'quadraticIn',
});

onMounted(async () => {
    loading.value = true;

    await fetchMetrics();

    loading.value = false;

    window.addEventListener('stats:refresh', async () => {
        await apiFetch('v1/reports/refresh', { method: 'POST' });
        await fetchMetrics();
    });
});

const isDatabaseHealthy = ref(false);
const isCacheHealthy = ref(false);
const uptime = ref('');

const lastUpdatedAt = ref(null);
const fetchMetrics = async () => {
    const { data } = await apiFetch<{ data: SystemReport[] }>('v1/reports');

    if (data.length > 0) {
        cpuMetricsOption.xAxis.data = data.map((metric) => metric.collected_at);
        cpuMetricsOption.series.data = data.map((metric) => metric.cpu_usage);

        ramMetricsOption.series.data = data.map((metric) => metric.ram_usage);
        ramMetricsOption.xAxis.data = data.map((metric) => metric.collected_at);
        ramMetricsOption.visualMap.max = data[0].ram_total;
        ramMetricsOption.yAxis.max = data[0].ram_total;

        networkMetricsOption.series[0].data = data.map(
            (metric) => metric.network_incoming
        );
        networkMetricsOption.series[1].data = data.map(
            (metric) => metric.network_outgoing
        );
        networkMetricsOption.xAxis.data = data.map(
            (metric) => metric.collected_at
        );

        isDatabaseHealthy.value = data[data.length - 1].is_database_up;
        isCacheHealthy.value = data[data.length - 1].is_cache_up;

        uptime.value = data[data.length - 1].uptime;

        lastUpdatedAt.value = data[data.length - 1].collected_at;
    }
};
</script>
