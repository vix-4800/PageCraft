<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="flex items-center gap-1 px-6 pt-6">
            <h2 class="text-2xl font-bold">Order</h2>
            <u-icon
                name="material-symbols:close"
                size="20"
                class="bg-red-500"
                v-if="order && order.status === 'cancelled'"
            />
        </div>
        <div class="p-6">
            <div class="min-w-full p-1 overflow-x-auto rounded">
                <div class="space-y-4" v-if="order">
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
                        class="bg-slate-100"
                        v-for="item in order.items"
                        :key="item.sku"
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
                            color="green"
                            size="md"
                            type="button"
                            v-if="order.status === 'processing'"
                            @click="updateOrderStatus('delivered')"
                        >
                            Deliver
                        </u-button>
                        <u-button
                            color="blue"
                            size="md"
                            type="button"
                            v-else-if="order.status === 'created'"
                            @click="updateOrderStatus('processing')"
                        >
                            Process
                        </u-button>

                        <u-button
                            color="red"
                            size="md"
                            type="button"
                            @click="updateOrderStatus('cancelled')"
                            v-if="
                                order.status !== 'cancelled' &&
                                order.status !== 'delivered'
                            "
                        >
                            Cancel
                        </u-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
});

const authStore = useAuthStore();
const apiUrl: string = useRuntimeConfig().public.apiUrl;
const route = useRoute();

const order = ref<Order>();
onMounted(async () => {
    const { data } = await $fetch<{ data: Order }>(
        `${apiUrl}/v1/orders/${route.params.id}`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                Authorization: `Bearer ${authStore.authToken}`,
            },
        }
    );

    order.value = data;
});

const updateOrderStatus = async (status: string) => {
    const { data } = await $fetch(`${apiUrl}/v1/orders/${route.params.id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${authStore.authToken}`,
        },
        body: {
            status: status,
        },
    });

    order.value = data;
};
</script>
