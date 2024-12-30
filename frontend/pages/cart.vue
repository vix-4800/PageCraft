<template>
    <div>
        <h1 class="text-3xl font-bold text-center text-gray-800">
            Shopping Cart
        </h1>

        <div class="grid gap-8 mt-16 md:grid-cols-3">
            <div class="space-y-4 md:col-span-2">
                <div
                    v-for="item in cartItems"
                    :key="item.product.slug"
                    class="grid items-start grid-cols-3 gap-4 pb-4 border-b border-gray-300"
                >
                    <div class="flex items-start col-span-2 gap-4">
                        <div
                            class="p-2 bg-white border-2 border-gray-300 rounded-md w-28 h-28 max-sm:w-24 max-sm:h-24 shrink-0"
                        >
                            <nuxt-link :to="`/products/${item.product.slug}`">
                                <nuxt-img
                                    :src="item.product.image"
                                    class="object-contain w-full h-full"
                                />
                            </nuxt-link>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <h3 class="text-base font-bold text-gray-800">
                                {{ item.product.name }}
                            </h3>
                            <div>
                                <span
                                    v-for="attribute in item.attributes"
                                    :key="attribute.name"
                                    class="block text-xs font-semibold text-gray-500"
                                >
                                    {{ capitalize(attribute.name) }}:
                                    {{ capitalize(attribute.value) }}
                                </span>
                            </div>

                            <div>
                                <u-button
                                    class="font-semibold"
                                    label="REMOVE"
                                    icon="material-symbols:delete-outline"
                                    color="red"
                                    @click="removeProductFromCart(item)"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="ml-auto">
                        <h4
                            class="text-lg font-bold text-gray-800 max-sm:text-base"
                        >
                            ${{ item.price }}
                        </h4>

                        <div
                            class="flex items-center gap-2 mt-6 text-xs text-gray-800 bg-transparent border border-gray-300 rounded-md outline-none"
                        >
                            <u-button
                                size="xs"
                                class="bg-transparent text-slate-600 hover:text-slate-900 hover:bg-transparent"
                                icon="ic:baseline-minus"
                                @click="store.decreaseProductQuantity(item)"
                            />

                            <span class="font-bold">
                                {{ store.getQuantity(item) }}
                            </span>

                            <u-button
                                size="xs"
                                class="bg-transparent text-slate-600 hover:text-slate-900 hover:bg-transparent"
                                icon="ic:baseline-plus"
                                @click="store.increaseProductQuantity(item)"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <u-form
                :state="state"
                class="p-4 bg-gray-100 rounded-md h-max"
                @submit="checkout"
            >
                <h3
                    class="pb-2 text-lg font-bold text-gray-800 border-b border-gray-300 max-sm:text-base"
                >
                    Order Summary
                </h3>

                <div class="mt-6">
                    <div>
                        <h3 class="mb-4 text-base font-semibold text-gray-800">
                            Enter Details
                        </h3>
                        <div class="space-y-3">
                            <u-input
                                v-model="state.name"
                                placeholder="Full Name"
                                icon="material-symbols:person"
                                trailing
                                color="orange"
                                size="lg"
                                required
                                :disabled="
                                    store.totalItems === 0 ||
                                    authStore.isAuthenticated
                                "
                            />

                            <u-input
                                v-model="state.email"
                                placeholder="Email"
                                type="email"
                                icon="material-symbols:mail"
                                trailing
                                color="orange"
                                size="lg"
                                required
                                :disabled="
                                    store.totalItems === 0 ||
                                    authStore.isAuthenticated
                                "
                            />

                            <u-input
                                v-model="state.phone"
                                placeholder="Phone No."
                                icon="material-symbols:phone-enabled"
                                trailing
                                color="orange"
                                size="lg"
                                required
                                :disabled="
                                    store.totalItems === 0 ||
                                    authStore.isAuthenticated
                                "
                            />

                            <u-textarea
                                v-model="state.note"
                                autoresize
                                placeholder="Note"
                                icon="material-symbols:note-add"
                                trailing
                                color="orange"
                                size="lg"
                                :disabled="
                                    store.totalItems === 0 ||
                                    authStore.isAuthenticated
                                "
                            />
                        </div>
                    </div>
                </div>

                <ul class="mt-6 space-y-3 text-gray-800">
                    <li class="flex flex-wrap gap-4 text-sm">
                        Subtotal
                        <span class="ml-auto font-bold">${{ subTotal }}</span>
                    </li>

                    <li class="flex flex-wrap gap-4 text-sm">
                        Shipping
                        <span class="ml-auto font-bold">${{ shipping }}</span>
                    </li>

                    <li class="flex flex-wrap gap-4 text-sm">
                        Tax
                        <span class="ml-auto font-bold">${{ tax }}</span>
                    </li>

                    <hr class="border-gray-300" />

                    <li class="flex flex-wrap gap-4 text-sm font-bold">
                        Total
                        <span class="ml-auto">${{ total }}</span>
                    </li>
                </ul>

                <div class="mt-6 space-y-3">
                    <u-button
                        color="orange"
                        :disabled="store.totalItems === 0"
                        class="justify-center font-semibold text-gray-800 disabled:opacity-75"
                        label="Checkout"
                        block
                        size="lg"
                        icon="material-symbols:shopping-cart"
                        type="submit"
                    />

                    <u-button
                        to="/"
                        label="Continue Shopping"
                        icon="ic:round-keyboard-arrow-left"
                        variant="outline"
                        color="blue"
                        size="lg"
                        block
                        class="justify-center font-semibold text-gray-800"
                    />
                </div>
            </u-form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { ProductVariation } from '~/types/product';

const store = useCartStore();
const authStore = useAuthStore();

const cartItems = ref<ProductVariation[]>([]);
onMounted(async () => {
    const skus = store.items.map((item) => item.sku);

    if (skus.length > 0) {
        const { data } = await apiFetch<{ data: ProductVariation[] }>(
            `v1/variations`,
            {
                params: {
                    skus: skus.join(','),
                },
            }
        );

        cartItems.value = data;

        calculateOrder();
    }
});

watch(store.items, () => {
    calculateOrder();
});

const state = reactive({
    name: authStore.isAuthenticated ? authStore.user?.name : '',
    email: authStore.isAuthenticated ? authStore.user?.email : '',
    phone: authStore.isAuthenticated ? authStore.user?.phone : '',
    note: '',
});

const subTotal = ref(0);
const shipping = ref(0);
const tax = ref(0);
const total = ref(0);

function calculateOrder() {
    subTotal.value = cartItems.value.reduce(
        (acc, item) => acc + item.price * store.getQuantity(item),
        0
    );

    shipping.value = Math.round(0.05 * subTotal.value * 100) / 100;
    tax.value = Math.round(0.1 * subTotal.value * 100) / 100;
    total.value =
        Math.round((subTotal.value + shipping.value + tax.value) * 100) / 100;
}

function clearDetails() {
    state.name = '';
    state.email = '';
    state.phone = '';
    state.note = '';
}

function removeProductFromCart(item: ProductVariation) {
    store.removeProduct(item);
    cartItems.value = cartItems.value.filter(
        (cartItem) => cartItem.sku !== item.sku
    );
}

const { $notify } = useNuxtApp();
const checkout = async () => {
    if (state.name === '' || state.email === '' || state.phone === '') {
        $notify('Please fill all the details', 'warning');
        return;
    }

    if (store.totalItems === 0) {
        $notify('Please add some products to cart', 'warning');
        return;
    }

    const payments = new cp.CloudPayments({
        language: 'en-US',
        email: '',
        applePaySupport: false,
        googlePaySupport: false,
        yandexPaySupport: true,
        tinkoffPaySupport: true,
        tinkoffInstallmentSupport: true,
        sbpSupport: true,
    });

    payments
        .pay('charge', {
            publicId: 'test_api_00000000000000000000002',
            description: 'Order Payment',
            amount: total.value,
            currency: 'USD',
            invoiceId: '123',
            accountId: '123',
            email: state.email,
            skin: 'mini',
            requireEmail: true,
        })
        .then(async function (widgetResult: { status: string }) {
            if (widgetResult.status === 'success') {
                await createOrder();

                $notify('Order Placed Successfully');
            } else {
                console.log('error', widgetResult);

                $notify('Payment Failed', 'error');
            }
        });
};

const createOrder = async () => {
    await apiFetch(`v1/orders`, {
        method: 'POST',
        body: {
            products: cartItems.value.map((item) => ({
                sku: item.sku,
                quantity: store.getQuantity(item),
            })),
            tax: tax.value,
            shipping: shipping.value,
            note: state.note,
            details: {
                name: state.name,
                email: state.email,
                phone: state.phone,
            },
        },
    });

    store.clearCart();
    calculateOrder();
    clearDetails();
    cartItems.value = [];
};
</script>
