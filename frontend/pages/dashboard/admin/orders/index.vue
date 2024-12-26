<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Orders</h2>
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
import { OrderStatus, type Order } from '~/types/order';

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
    const response = await apiFetch<{ data: Order[] }>(`v1/orders`);

    orders.value = response.data;
    ordersLoading.value = false;
    orders.value.forEach((sale) => {
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
});

function select(row: Order) {
    return navigateTo('/dashboard/admin/orders/' + row.id);
}
</script>
