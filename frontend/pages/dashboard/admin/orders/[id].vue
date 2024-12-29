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
                    class="sm:w-fit w-full px-3.5 py-2 bg-indigo-600 hover:bg-indigo-800 transition-all duration-700 ease-in-out rounded-lg shadow-[0px_1px_2px_0px_rgba(16,_24,_40,_0.05)] justify-center items-center flex"
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

const deliveryStatuses = [
    {
        label: 'Created',
        value: OrderStatus.CREATED,
        icon: 'material-symbols:pending-actions',
        active: true,
    },
    {
        label: 'Packed',
        // value: OrderStatus.PACKED,
        icon: 'material-symbols:package-2',
        active: true,
    },
    {
        label: 'Processing',
        value: OrderStatus.PROCESSING,
        icon: 'material-symbols:delivery-truck-speed',
        active: true,
    },
    {
        label: 'Delivered',
        value: OrderStatus.DELIVERED,
        icon: 'material-symbols:location-on',
        active: false,
    },
];
</script>
