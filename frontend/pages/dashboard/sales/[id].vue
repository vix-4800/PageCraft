<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="flex items-center gap-1 px-6 pt-6">
            <h2 class="text-2xl font-bold">Order</h2>
            <u-icon
                v-if="order && order.status === OrdersStatus.PENDING"
                name="material-symbols:close"
                size="20"
                class="bg-red-500"
            />
        </div>
        <div class="p-6">
            <div class="min-w-full p-1 overflow-x-auto rounded">
                <div v-if="order" class="space-y-4">
                    <div class="flex gap-2">
                        <u-form-group label="Status" class="w-1/2">
                            <span
                                class="block w-full border-0 border-blue-500 rounded-md text-sm px-2.5 py-1.5 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400"
                            >
                                {{
                                    order.status.charAt(0).toUpperCase() +
                                    order.status.slice(1)
                                }}
                            </span>
                        </u-form-group>

                        <u-form-group label="Total" class="w-1/2">
                            <span
                                class="block w-full border-0 border-blue-500 rounded-md text-sm px-2.5 py-1.5 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400"
                            >
                                {{ order.total }}
                            </span>
                        </u-form-group>
                    </div>

                    <u-card
                        v-for="item in order.items"
                        :key="item.sku"
                        class="bg-slate-100"
                    >
                        <template #header>
                            <h3 class="text-lg font-bold">
                                Product - '{{ item.product.name }}'
                            </h3>
                        </template>

                        <p class="text-sm text-gray-600">Sku: {{ item.sku }}</p>

                        <p class="text-sm text-gray-600">
                            Quantity: {{ item.quantity }}
                        </p>
                    </u-card>

                    <div class="flex gap-2">
                        <u-button
                            v-if="order.status === OrderStatus.PROCESSING"
                            color="green"
                            size="md"
                            label="Deliver"
                            @click="updateOrderStatus(OrderStatus.DELIVERED)"
                        />

                        <u-button
                            v-else-if="order.status === OrderStatus.CREATED"
                            color="blue"
                            size="md"
                            label="Process"
                            @click="updateOrderStatus(OrderStatus.PROCESSING)"
                        />

                        <u-button
                            v-if="
                                order.status !== OrderStatus.CANCELLED &&
                                order.status !== OrderStatus.DELIVERED
                            "
                            color="red"
                            size="md"
                            label="Cancel Order"
                            @click="updateOrderStatus(OrderStatus.CANCELLED)"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { OrderStatus, type Order } from '~/types/order';
definePageMeta({
    layout: 'dashboard',
    middleware: ['sanctum:auth'],
});

const route = useRoute();

const order = ref<Order>();
onMounted(async () => {
    const { data } = await apiFetch<{ data: Order }>(
        `v1/orders/${route.params.id}`
    );

    order.value = data;
});

const updateOrderStatus = async (status: OrderStatus) => {
    const allowedStatuses = [
        OrderStatus.PROCESSING,
        OrderStatus.DELIVERED,
        OrderStatus.CANCELLED,
    ];

    if (!allowedStatuses.includes(status)) {
        console.error('Invalid status:', status);
        return;
    }

    const { data } = await apiFetch<{ data: Order }>(
        `v1/orders/${route.params.id}`,
        {
            method: 'PUT',
            body: {
                status: status.toString(),
            },
        }
    );

    order.value = data;
};
</script>
