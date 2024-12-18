<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Sales</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full overflow-x-auto rounded">
                <u-table
                    :columns="ordersColumns"
                    :rows="orders"
                    :loading="ordersLoading"
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
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
});

const ordersColumns = [
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
const orders = ref<Order[]>([]);
const ordersLoading = ref(true);

onMounted(async () => {
    const apiUrl: string = useRuntimeConfig().public.apiUrl;

    const response = await $fetch<{ data: Order[] }>(`${apiUrl}/v1/orders`, {
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${useAuthStore().authToken}`,
        },
    });

    orders.value = response.data;
    ordersLoading.value = false;
    orders.value.forEach((sale) => {
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
});

function select(row: Order) {
    return navigateTo('/dashboard/sales/' + row.id);
}
</script>
