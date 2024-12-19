<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-12 md:gap-6">
        <div
            class="p-6 bg-white border rounded-lg border-slate-200 sm:col-span-6 xl:col-span-3"
        >
            <dl>
                <dt class="text-2xl font-bold">{{ statistics.users.today }}</dt>
                <dd class="text-sm font-medium text-slate-500">Users today</dd>
            </dl>
        </div>

        <div
            class="p-6 bg-white border rounded-lg border-slate-200 sm:col-span-6 xl:col-span-3"
        >
            <dl>
                <dt class="text-2xl font-bold">{{ statistics.users.total }}</dt>
                <dd class="text-sm font-medium text-slate-500">Users total</dd>
            </dl>
        </div>

        <div
            class="p-6 bg-white border rounded-lg border-slate-200 sm:col-span-6 xl:col-span-3"
        >
            <dl>
                <dt class="text-2xl font-bold">{{ statistics.sales.today }}</dt>
                <dd class="text-sm font-medium text-slate-500">Sales today</dd>
            </dl>
        </div>

        <div
            class="p-6 bg-white border rounded-lg border-slate-200 sm:col-span-6 xl:col-span-3"
        >
            <dl>
                <dt class="text-2xl font-bold">{{ statistics.sales.total }}</dt>
                <dd class="text-sm font-medium text-slate-500">Sales total</dd>
            </dl>
        </div>

        <div
            class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12 lg:col-span-6"
        >
            <dl class="px-6 pt-6">
                <dt class="text-2xl font-bold">
                    ${{ statistics.earnings.total }}
                </dt>
                <dd class="text-sm font-medium text-slate-500">
                    Total Earnings
                </dd>
            </dl>
            <div class="h-64 px-4">
                <v-chart :option="earningsOption" :loading="earningsLoading" />
            </div>
        </div>

        <div
            class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12 lg:col-span-6"
        >
            <dl class="px-6 pt-6">
                <dt class="text-2xl font-bold">
                    {{ statistics.pageviews.total }}
                </dt>
                <dd class="text-sm font-medium text-slate-500">
                    Total Pageviews
                </dd>
            </dl>
            <div class="h-64">
                <v-chart
                    :option="pageviewsOption"
                    :loading="pageviewsLoading"
                />
            </div>
        </div>

        <div
            class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
        >
            <div class="px-6 pt-6">
                <h2 class="text-2xl font-bold">7 Latest Sales</h2>
                <h3 class="text-sm font-medium text-slate-500">
                    You have {{ statistics.sales.today }} new sale{{
                        statistics.sales.today > 1 ? 's' : ''
                    }}
                    today!
                </h3>
            </div>
            <div class="p-6">
                <div class="min-w-full overflow-x-auto rounded">
                    <u-table
                        :columns="salesColumns"
                        :rows="sales"
                        :loading="latestSalesLoading"
                        :loading-state="{
                            icon: 'i-heroicons-arrow-path-20-solid',
                            label: 'Loading...',
                        }"
                        :progress="{ color: 'blue', animation: 'carousel' }"
                        class="w-full"
                        @select="select"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Order } from '~/types/order';
definePageMeta({
    layout: 'dashboard',
});

const apiUrl: string = useRuntimeConfig().public.apiUrl;

const statistics = reactive({
    users: {
        today: 0,
        total: 0,
    },
    sales: {
        today: 0,
        total: 0,
    },
    earnings: {
        today: 0,
        total: 0,
    },
    pageviews: {
        today: 0,
        total: 0,
    },
});

const earningsLoading = ref(true);
const earningsOption = ref({
    xAxis: {
        data: [],
        type: 'category',
    },
    yAxis: {
        type: 'value',
    },
    series: [
        {
            data: [],
            type: 'line',
        },
    ],
});

const pageviewsLoading = ref(true);
const pageviewsOption = ref({
    xAxis: {
        type: 'category',
        data: [0, 0, 0],
    },
    yAxis: {
        type: 'value',
    },
    series: [
        {
            data: ['2024-01-01', '2024-01-02', '2024-01-03'],
            type: 'line',
        },
    ],
});

onMounted(async () => {
    await getStatisticsOverview();
    await getWeekSales();
    // await getWeekPageviews();
    await getLatestSales();
});

async function getStatisticsOverview() {
    const response = await $fetch(`${apiUrl}/v1/statistics/overview`, {
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${useAuthStore().authToken}`,
        },
    });

    statistics.users.today = response.data.users.today;
    statistics.users.total = response.data.users.total;

    statistics.sales.today = response.data.sales.today;
    statistics.sales.total = response.data.sales.total;

    statistics.earnings.today = response.data.earnings.today;
    statistics.earnings.total = response.data.earnings.total;
}

async function getWeekSales() {
    const response = await $fetch(`${apiUrl}/v1/statistics/sales/last-week`, {
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${useAuthStore().authToken}`,
        },
    });
    earningsOption.value.xAxis.data = Object.keys(response.data);
    earningsOption.value.series[0].data = Object.values(response.data);
    earningsLoading.value = false;
}

const salesColumns = [
    {
        key: 'id',
        label: 'ID',
        sortable: true,
    },
    {
        key: 'user.email',
        label: 'Email',
    },
    {
        key: 'status',
        label: 'Status',
        sortable: true,
    },
    {
        key: 'total',
        label: 'Total',
        sortable: true,
    },
    {
        key: 'created_at',
        label: 'Date',
        sortable: true,
    },
];
const sales = ref<Order[]>([]);
const latestSalesLoading = ref(true);
async function getLatestSales() {
    const endDate = new Date();
    const startDate = new Date(endDate.getTime() - 1000 * 60 * 60 * 24);

    const response = await $fetch<{ data: Order[] }>(
        `${apiUrl}/v1/orders?start_date=${startDate.toISOString()}&end_date=${endDate.toISOString()}&limit=7`,
        {
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                Authorization: `Bearer ${useAuthStore().authToken}`,
            },
        }
    );

    sales.value = response.data;
    latestSalesLoading.value = false;
    sales.value.forEach((sale) => {
        sale['class'] = `bg-${
            sale.status === 'created'
                ? 'yellow'
                : sale.status === 'cancelled'
                ? 'red'
                : sale.status === 'delivered'
                ? 'green'
                : sale.status === 'processing'
                ? 'blue'
                : ''
        }-50`;
    });
}

function select(row: Order) {
    return navigateTo('/dashboard/sales/' + row.id);
}
</script>
