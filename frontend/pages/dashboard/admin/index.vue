<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-12 md:gap-6">
        <card-mini
            label="Registered today"
            :value="statistics.users.today.toString()"
        />
        <card-mini
            label="Registered total"
            :value="statistics.users.total.toString()"
        />
        <card-mini
            label="Sales today"
            :value="statistics.sales.today.toString()"
        />
        <card-mini
            label="Sales total"
            :value="statistics.sales.total.toString()"
        />

        <div
            class="col-span-12 overflow-hidden bg-white border dark:bg-slate-700 dark:border-0 rounded-xl border-slate-200"
        >
            <dl class="px-6 pt-6">
                <dt class="text-2xl font-bold">
                    ${{ statistics.earnings.total }}
                </dt>
                <dd class="text-sm font-medium text-slate-500">
                    Total Earnings
                </dd>
            </dl>
            <div class="px-4 h-96">
                <v-chart
                    :option="earningsOption"
                    :loading="earningsLoading"
                    :autoresize="true"
                />
            </div>
        </div>

        <div
            id="widgetIframe"
            class="col-span-12 border rounded-xl border-slate-200 dark:border-0"
        >
            <div class="px-6 pt-6">
                <span class="text-2xl font-bold">Visits</span>

                <matomo-widget
                    container-id="EcommerceOverview"
                    module-to-widgetize="CoreHome"
                    action-to-widgetize="renderWidgetContainer"
                    :height="500"
                />
            </div>
        </div>

        <div
            class="overflow-hidden bg-white border dark:bg-slate-700 rounded-xl border-slate-200 sm:col-span-12"
        >
            <div class="px-6 pt-6">
                <h2 class="text-2xl font-bold">
                    {{ latestSalesLimit }} Latest Sales
                </h2>
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
import { OrderStatus, type Order } from '~/types/order';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

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
});

const earningsLoading = ref(true);
const earningsOption = ref<ECOption>({
    xAxis: {
        data: [],
        type: 'category',
        boundaryGap: false,
    },
    yAxis: {
        type: 'value',
    },
    series: {
        data: [],
        type: 'line',
        showSymbol: false,
        name: 'Earnings',
    },
    tooltip: {
        trigger: 'axis',
    },
    toolbox: {
        right: 10,
        feature: {
            saveAsImage: {},
        },
    },
});

onMounted(async () => {
    await getStatisticsOverview();
    await getWeekSales();
    await getLatestSales();
});

async function getStatisticsOverview() {
    const { data } = await apiFetch<{
        data: {
            users: { today: number; total: number };
            sales: { today: number; total: number };
            earnings: { today: number; total: number };
        };
    }>(`v1/statistics/overview`);

    statistics.users.today = data.users.today;
    statistics.users.total = data.users.total;

    statistics.sales.today = data.sales.today;
    statistics.sales.total = data.sales.total;

    statistics.earnings.today = data.earnings.today;
    statistics.earnings.total = data.earnings.total;
}

async function getWeekSales() {
    const { data } = await apiFetch(`v1/statistics/sales/last-week`);

    earningsOption.value.xAxis.data = Object.keys(data);
    earningsOption.value.series.data = Object.values(data);
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
const latestSalesLimit = ref(10);

async function getLatestSales() {
    const { data } = await apiFetch<{ data: Order[] }>(`v1/orders/latest`, {
        params: {
            limit: latestSalesLimit.value,
        },
    });

    sales.value = data;
    latestSalesLoading.value = false;
    sales.value.forEach((sale) => {
        sale['class'] = `bg-${
            sale.status === OrderStatus.CREATED
                ? 'yellow'
                : sale.status === OrderStatus.CANCELLED
                ? 'red'
                : sale.status === OrderStatus.DELIVERED
                ? 'green'
                : sale.status === OrderStatus.PROCESSING
                ? 'blue'
                : ''
        }-50`;
    });
}

function select(row: Order) {
    return navigateTo('/dashboard/admin/orders/' + row.id);
}
</script>
