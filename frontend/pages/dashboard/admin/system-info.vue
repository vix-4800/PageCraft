<template>
    <div>
        <dashboard-page-name title="System Info" />

        <div class="h-[40rem]">
            <v-chart
                :option="metricsOption"
                :loading="metricsLoading"
                :autoresize="true"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { PerformanceMetric } from '~/types/site_metric';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const metricsLoading = ref(false);
const metricsOption = ref<ECOption>({
    xAxis: [
        {
            data: [],
            type: 'category',
        },
        {
            data: [],
            type: 'category',
            gridIndex: 1,
        },
    ],
    yAxis: [
        {
            type: 'value',
            max: 100,
            min: 0,
        },
        {
            type: 'value',
            gridIndex: 1,
            max: 0,
            min: 0,
        },
    ],
    series: [
        {
            data: [],
            type: 'line',
            showSymbol: false,
        },
        {
            data: [],
            type: 'line',
            xAxisIndex: 1,
            yAxisIndex: 1,
            showSymbol: false,
        },
    ],
    title: [
        {
            left: 'center',
            text: 'CPU Usage',
        },
        {
            top: '50%',
            left: 'center',
            text: 'RAM Usage',
        },
    ],
    tooltip: {
        trigger: 'axis',
    },
    visualMap: [
        {
            show: false,
            type: 'continuous',
            seriesIndex: 0,
            min: 0,
            max: 100,
        },
        {
            show: false,
            type: 'continuous',
            seriesIndex: 1,
            min: 0,
            max: 0,
        },
    ],
    toolbox: {
        right: 10,
        feature: {
            saveAsImage: {},
        },
    },
    grid: [
        {
            bottom: '60%',
        },
        {
            top: '60%',
        },
    ],
    animationEasing: 'quadraticIn',
});

onMounted(async () => {
    metricsLoading.value = true;

    const { data } = await apiFetch<{ data: PerformanceMetric[] }>(
        'v1/metrics'
    );

    metricsOption.value.xAxis[0].data = data.map(
        (metric) => metric.collected_at
    );
    metricsOption.value.xAxis[1].data = data.map(
        (metric) => metric.collected_at
    );

    metricsOption.value.series[0].data = data.map((metric) => metric.cpu_usage);
    metricsOption.value.series[1].data = data.map((metric) => metric.ram_usage);
    metricsOption.value.visualMap[1].max = data[0].ram_total;
    metricsOption.value.yAxis[1].max = data[0].ram_total;

    metricsLoading.value = false;
});
</script>
