<template>
    <div>
        <dashboard-page-name title="My Orders" />

        <u-table
            :columns="ordersColumns"
            :rows="orders"
            :loading="ordersLoading"
            :loading-state="{
                icon: 'i-heroicons-arrow-path-20-solid',
                label: 'Loading...',
            }"
            :progress="{ color: 'blue', animation: 'carousel' }"
            :empty-state="{
                icon: 'material-symbols:remove-shopping-cart',
                label: 'No orders',
            }"
            class="w-full"
        />
    </div>
</template>

<script lang="ts" setup>
import { OrderStatus, type Order } from '~/types/order';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'verified'],
});

const ordersColumns = [
    {
        key: 'id',
        label: 'ID',
        sortable: true,
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
    const { data } = await apiFetch<{ data: Order[] }>(`user/orders`);

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
</script>
