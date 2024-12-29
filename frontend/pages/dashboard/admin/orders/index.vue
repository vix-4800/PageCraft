<template>
    <div>
        <DashboardPageName title="Orders" />

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
            :empty-state="{
                icon: 'material-symbols:remove-shopping-cart',
                label: 'No orders',
            }"
            @select="select"
        />
    </div>
</template>

<script lang="ts" setup>
import { OrderStatus, type Order } from '~/types/order';

definePageMeta({
    layout: 'dashboard',
    middleware: ['verified'],
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
    const { data } = await apiFetch<{ data: Order[] }>(`v1/orders`);

    orders.value = data;
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
