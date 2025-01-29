<template>
    <div>
        <dashboard-page-name title="System Info">
            <template #actions>
                <u-button
                    color="blue"
                    size="md"
                    icon="material-symbols:refresh"
                    :loading="refreshing"
                    label="Refresh Now"
                    @click="refreshLogs"
                />
            </template>
        </dashboard-page-name>

        <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-6 md:gap-6">
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
import type { PerformanceMetric } from '~/types/site_metric';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

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
const cpuMetricsOption = ref<ECOption>({
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
const ramMetricsOption = ref<ECOption>({
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
const networkMetricsOption = ref<ECOption>({
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
    setInterval(fetchMetrics, 15000);

    loading.value = false;
});

const isDatabaseHealthy = ref(false);
const isCacheHealthy = ref(false);
const fetchMetrics = async () => {
    const { data } = await apiFetch<{ data: PerformanceMetric[] }>(
        'v1/metrics'
    );

    if (data.length > 0) {
        cpuMetricsOption.value.xAxis.data = data.map(
            (metric) => metric.collected_at
        );
        cpuMetricsOption.value.series.data = data.map(
            (metric) => metric.cpu_usage
        );

        ramMetricsOption.value.series.data = data.map(
            (metric) => metric.ram_usage
        );
        ramMetricsOption.value.xAxis.data = data.map(
            (metric) => metric.collected_at
        );
        ramMetricsOption.value.visualMap.max = data[0].ram_total;
        ramMetricsOption.value.yAxis.max = data[0].ram_total;

        networkMetricsOption.value.series[0].data = data.map(
            (metric) => metric.network_incoming
        );
        networkMetricsOption.value.series[1].data = data.map(
            (metric) => metric.network_outgoing
        );
        networkMetricsOption.value.xAxis.data = data.map(
            (metric) => metric.collected_at
        );

        isDatabaseHealthy.value = data[data.length - 1].is_database_up;
    }
};

const refreshing = ref(false);
const refreshLogs = async () => {
    refreshing.value = true;
    await apiFetch('v1/metrics/refresh', { method: 'POST' });
    await fetchMetrics();
    refreshing.value = false;
};
</script>
