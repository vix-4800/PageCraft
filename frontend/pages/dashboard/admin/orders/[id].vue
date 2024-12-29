<template>
    <div v-if="order">
        <DashboardPageName
            title="Order"
            :subtitle="`#${order?.id}`"
            :description="new Date(order.created_at).toDateString()"
        >
            <template #actions>
                <u-button
                    label="Print Invoice"
                    icon="mdi:printer"
                    color="blue"
                    size="md"
                />
            </template>
        </DashboardPageName>

        <div class="space-y-4">
            <section
                class="flex flex-col items-start justify-start w-full gap-5 bg-white rounded-xl"
            >
                <h2
                    class="w-full pb-2 text-2xl font-semibold leading-9 text-gray-900 border-b border-gray-200 font-manrope"
                >
                    Tracking
                </h2>
                <div class="flex-col items-center justify-center w-full px-8">
                    <ol
                        class="flex flex-col items-center justify-between w-full gap-4 md:flex-row md:items-start md:gap-1"
                    >
                        <li
                            v-for="step in deliveryStatuses"
                            :key="step.label"
                            class="relative flex justify-start group"
                        >
                            <div
                                class="z-10 flex flex-col items-center justify-start w-full gap-1 mr-1"
                            >
                                <div
                                    class="justify-center items-center gap-1.5 inline-flex"
                                >
                                    <h5
                                        class="text-lg font-medium leading-normal text-center"
                                        :class="{
                                            'text-blue-600': step.active,
                                            'text-gray-500': !step.active,
                                        }"
                                    >
                                        {{ step.label }}
                                    </h5>
                                    <u-icon
                                        :name="step.icon"
                                        size="20"
                                        :class="{
                                            'text-blue-600': step.active,
                                            'text-gray-500': !step.active,
                                        }"
                                    />
                                </div>
                                <h6
                                    class="text-base font-normal leading-relaxed text-center text-gray-500"
                                >
                                    20 May, 2024
                                </h6>
                            </div>
                        </li>
                    </ol>
                </div>
            </section>

            <section
                class="flex flex-col items-start justify-start w-full gap-5 bg-white rounded-xl"
            >
                <h2
                    class="w-full pb-2 text-2xl font-semibold leading-9 text-gray-900 border-b border-gray-200 font-manrope"
                >
                    Items
                </h2>
                <div
                    class="flex flex-col items-start justify-start w-full gap-5 pb-5 border-b border-gray-200"
                >
                    <div
                        v-for="item in order.items"
                        :key="item.sku"
                        class="grid items-center justify-start w-full grid-cols-1 gap-4 lg:gap-8 md:grid-cols-12"
                    >
                        <div
                            class="flex flex-col items-center justify-start w-full col-span-12 gap-4 md:col-span-8 lg:gap-5 md:flex-row"
                        >
                            <nuxt-link
                                :to="
                                    '/dashboard/admin/products/' +
                                    item.product.slug
                                "
                            >
                                <nuxt-img
                                    class="object-cover rounded-md"
                                    :src="item.image"
                                    width="125"
                                    :alt="item.product.name"
                                />
                            </nuxt-link>

                            <div
                                class="inline-flex flex-col items-center justify-start w-full gap-1 md:items-start"
                            >
                                <nuxt-link
                                    :to="
                                        '/dashboard/admin/products/' +
                                        item.product.slug
                                    "
                                >
                                    <h4
                                        class="text-xl font-medium leading-8 text-gray-900 hover:text-indigo-600"
                                    >
                                        {{ item.product.name }}
                                    </h4>
                                </nuxt-link>
                                <div
                                    class="flex flex-col items-center justify-start md:items-start"
                                >
                                    <span
                                        v-for="attribute in item.attributes"
                                        :key="attribute.name"
                                        class="text-base font-normal leading-relaxed text-gray-500 whitespace-nowrap"
                                    >
                                        <span class="font-semibold">
                                            {{
                                                capitalize(attribute.name)
                                            }} </span
                                        >: {{ capitalize(attribute.value) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-col items-center justify-between col-span-12 gap-4 md:col-span-4 md:flex-row"
                        >
                            <h4
                                class="text-xl font-semibold leading-8 text-gray-500"
                            >
                                ${{ item.price }} x
                                {{ item.quantity }}
                            </h4>
                            <h4
                                class="text-xl font-semibold leading-8 text-gray-900"
                            >
                                ${{ item.price * item.quantity }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col items-start justify-start w-full gap-5"
                >
                    <div
                        class="flex flex-col items-start justify-start w-full gap-4"
                    >
                        <div
                            class="flex justify-between w-full leading-relaxed text-gray-500"
                        >
                            <span class="text-base font-normal">Subtotal</span>
                            <span class="text-base font-medium">$210.00</span>
                        </div>
                        <div
                            class="flex justify-between w-full leading-relaxed text-gray-500"
                        >
                            <span class="text-base font-normal">
                                Shipping Charge
                            </span>
                            <span class="text-base font-medium">$10.00</span>
                        </div>

                        <div
                            class="flex justify-between w-full leading-relaxed text-gray-500"
                        >
                            <span class="text-base font-normal"> Tax Fee </span>
                            <span class="text-base font-medium">$22.00</span>
                        </div>
                    </div>

                    <div
                        class="inline-flex items-start justify-between w-full gap-6"
                    >
                        <h5
                            class="text-lg font-semibold leading-relaxed text-gray-900"
                        >
                            Total
                        </h5>
                        <h5
                            class="text-lg font-semibold leading-relaxed text-right text-gray-900"
                        >
                            ${{ order.total }}
                        </h5>
                    </div>
                </div>
            </section>

            <section
                class="flex flex-col items-start justify-start w-full gap-1"
            >
                <h6
                    class="text-base font-medium leading-relaxed text-right text-gray-900"
                >
                    Order Note:
                </h6>
                <p class="text-sm font-normal leading-normal text-gray-500">
                    Make sure to ship all the ordered items together by Friday.
                    I've emailed you the details, so please check it an review
                    it. Thank You!
                </p>
            </section>

            <div
                v-if="order.status !== OrderStatus.DELIVERED"
                class="flex gap-2"
            >
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
                    v-if="order.status !== OrderStatus.CANCELLED"
                    color="red"
                    size="md"
                    label="Cancel Order"
                    @click="updateOrderStatus(OrderStatus.CANCELLED)"
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { OrderStatus, type Order } from '~/types/order';

definePageMeta({
    layout: 'dashboard',
    middleware: ['verified'],
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

const deliveryValue = ref<number>(0);
watch(
    () => order.value,
    (newOrder) => {
        switch (newOrder?.status) {
            case OrderStatus.CREATED:
                deliveryValue.value = 0;
                break;
            case OrderStatus.PACKED:
                deliveryValue.value = 1;
                break;
            case OrderStatus.PROCESSING:
                deliveryValue.value = 2;
                break;
            case OrderStatus.DELIVERED:
                deliveryValue.value = 3;
                break;
            default:
                deliveryValue.value = 0;
                break;
        }
    }
);

const deliveryStatuses = computed(() => [
    {
        label: 'Created',
        icon: 'material-symbols:pending-actions',
        active: deliveryValue.value >= 0,
    },
    {
        label: 'Packed',
        icon: 'material-symbols:package-2',
        active: deliveryValue.value >= 1,
    },
    {
        label: 'Processing',
        icon: 'material-symbols:delivery-truck-speed',
        active: deliveryValue.value >= 2,
    },
    {
        label: 'Delivered',
        icon: 'material-symbols:location-on',
        active: deliveryValue.value === 3,
    },
]);
</script>
