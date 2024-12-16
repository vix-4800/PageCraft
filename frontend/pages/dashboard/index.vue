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
            <div class="h-64">
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
                <h2 class="text-2xl font-bold">Latest Sales</h2>
                <h3 class="text-sm font-medium text-slate-500">
                    You have {{ statistics.sales.today }} new sale{{
                        statistics.sales.today > 1 ? 's' : ''
                    }}
                    today!
                </h3>
            </div>
            <div class="p-6">
                <div class="min-w-full overflow-x-auto rounded">
                    <table class="min-w-full text-sm align-middle">
                        <thead>
                            <tr class="border-b-2 border-slate-100">
                                <th
                                    class="px-3 py-2 text-sm font-semibold tracking-wider uppercase text-start text-slate-700"
                                >
                                    id
                                </th>
                                <th
                                    class="hidden px-3 py-2 text-sm font-semibold tracking-wider uppercase text-start text-slate-700 md:table-cell"
                                >
                                    Email
                                </th>
                                <th
                                    class="hidden px-3 py-2 text-sm font-semibold tracking-wider uppercase text-start text-slate-700 md:table-cell"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-3 py-2 text-sm font-semibold tracking-wider uppercase text-end text-slate-700"
                                >
                                    Total
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="p-3 text-start">
                                    <a
                                        class="font-medium text-indigo-500 hover:text-indigo-700"
                                        href="javascript:void(0)"
                                    >
                                        order_0006578
                                    </a>
                                </td>
                                <td
                                    class="hidden p-3 text-slate-600 md:table-cell"
                                >
                                    g.taylor@example.com
                                </td>
                                <td class="hidden p-3 text-start md:table-cell">
                                    <div
                                        class="inline-block px-2 py-1 text-xs font-semibold leading-4 text-orange-700 border border-orange-200 rounded-full bg-orange-50"
                                    >
                                        Pending
                                    </div>
                                </td>
                                <td class="p-3 font-medium text-end">
                                    $185.13
                                </td>
                            </tr>
                            <tr class="bg-slate-50">
                                <td class="p-3 text-start">
                                    <a
                                        class="font-medium text-indigo-500 hover:text-indigo-700"
                                        href="javascript:void(0)"
                                    >
                                        order_0006577
                                    </a>
                                </td>
                                <td
                                    class="hidden p-3 text-slate-600 md:table-cell"
                                >
                                    j.keily@example.com
                                </td>
                                <td class="hidden p-3 text-start md:table-cell">
                                    <div
                                        class="inline-block px-2 py-1 text-xs font-semibold leading-4 text-orange-700 border border-orange-200 rounded-full bg-orange-50"
                                    >
                                        Pending
                                    </div>
                                </td>
                                <td class="p-3 font-medium text-end">
                                    $280.63
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3 text-start">
                                    <a
                                        class="font-medium text-indigo-500 hover:text-indigo-700"
                                        href="javascript:void(0)"
                                    >
                                        order_0006576
                                    </a>
                                </td>
                                <td
                                    class="hidden p-3 text-slate-600 md:table-cell"
                                >
                                    n.hart@example.com
                                </td>
                                <td class="hidden p-3 text-start md:table-cell">
                                    <div
                                        class="inline-block px-2 py-1 text-xs font-semibold leading-4 border rounded-full border-emerald-200 bg-emerald-50 text-emerald-700"
                                    >
                                        Completed
                                    </div>
                                </td>
                                <td class="p-3 font-medium text-end">
                                    $110.69
                                </td>
                            </tr>
                            <tr class="bg-slate-50">
                                <td class="p-3 text-start">
                                    <a
                                        class="font-medium text-indigo-500 hover:text-indigo-700"
                                        href="javascript:void(0)"
                                    >
                                        order_0006575
                                    </a>
                                </td>
                                <td
                                    class="hidden p-3 text-slate-600 md:table-cell"
                                >
                                    j.doe@example.com
                                </td>
                                <td class="hidden p-3 text-start md:table-cell">
                                    <div
                                        class="inline-block px-2 py-1 text-xs font-semibold leading-4 border rounded-full border-emerald-200 bg-emerald-50 text-emerald-700"
                                    >
                                        Completed
                                    </div>
                                </td>
                                <td class="p-3 font-medium text-end">
                                    $120.37
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3 text-start">
                                    <a
                                        class="font-medium text-indigo-500 hover:text-indigo-700"
                                        href="javascript:void(0)"
                                    >
                                        order_0006574
                                    </a>
                                </td>
                                <td
                                    class="hidden p-3 text-slate-600 md:table-cell"
                                >
                                    o.smith@example.com
                                </td>
                                <td class="hidden p-3 text-start md:table-cell">
                                    <div
                                        class="inline-block px-2 py-1 text-xs font-semibold leading-4 border rounded-full border-emerald-200 bg-emerald-50 text-emerald-700"
                                    >
                                        Completed
                                    </div>
                                </td>
                                <td class="p-3 font-medium text-end">
                                    $150.27
                                </td>
                            </tr>
                            <tr class="bg-slate-50">
                                <td class="p-3 text-start">
                                    <a
                                        class="font-medium text-indigo-500 hover:text-indigo-700"
                                        href="javascript:void(0)"
                                    >
                                        order_0006573
                                    </a>
                                </td>
                                <td
                                    class="hidden p-3 text-slate-600 md:table-cell"
                                >
                                    n.hart@example.com
                                </td>
                                <td class="hidden p-3 text-start md:table-cell">
                                    <div
                                        class="inline-block px-2 py-1 text-xs font-semibold leading-4 border rounded-full border-emerald-200 bg-emerald-50 text-emerald-700"
                                    >
                                        Completed
                                    </div>
                                </td>
                                <td class="p-3 font-medium text-end">
                                    $215.25
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
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
    pageviews: {
        today: 0,
        total: 0,
    },
});

const earningsLoading = ref(true);
const earningsOption = ref({
    xAxis: {
        type: 'category',
        data: [],
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
    const apiUrl: string = useRuntimeConfig().public.apiUrl;

    const response = await $fetch(`${apiUrl}/v1/statistics`, {
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
    earningsOption.value.xAxis.data = Object.keys(
        response.data.sales.last_seven_days
    );
    earningsOption.value.series[0].data = Object.values(
        response.data.sales.last_seven_days
    );
    earningsLoading.value = false;

    statistics.earnings.today = response.data.earnings.today;
    statistics.earnings.total = response.data.earnings.total;
});
</script>
