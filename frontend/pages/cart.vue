<template>
    <h1 class="text-3xl font-bold text-center text-gray-800">Shopping Cart</h1>

    <div class="grid gap-8 mt-16 md:grid-cols-3">
        <div class="space-y-4 md:col-span-2">
            <div
                v-for="item in store.items"
                :key="item.product.slug"
                class="grid items-start grid-cols-3 gap-4 pb-4 border-b border-gray-300"
            >
                <div class="flex items-start col-span-2 gap-4">
                    <div
                        class="p-2 bg-white border-2 border-gray-300 rounded-md w-28 h-28 max-sm:w-24 max-sm:h-24 shrink-0"
                    >
                        <nuxt-img
                            :src="item.product.image"
                            class="object-contain w-full h-full"
                        />
                    </div>

                    <div class="flex flex-col">
                        <h3 class="text-base font-bold text-gray-800">
                            {{ item.product.name }}
                        </h3>
                        <p
                            v-for="attribute in item.product.attributes"
                            :key="attribute.name"
                            class="text-xs font-semibold text-gray-500 mt-0.5"
                        >
                            {{
                                attribute.name.charAt(0).toUpperCase() +
                                attribute.name.slice(1)
                            }}:
                            {{
                                attribute.value.charAt(0).toUpperCase() +
                                attribute.value.slice(1)
                            }}
                        </p>

                        <button
                            type="button"
                            class="flex items-center gap-1 mt-6 text-xs font-semibold text-red-500 shrink-0"
                            @click="store.removeProduct(item.product)"
                        >
                            <u-icon
                                name="material-symbols:delete-outline"
                                size="20"
                            />
                            REMOVE
                        </button>
                    </div>
                </div>

                <div class="ml-auto">
                    <h4
                        class="text-lg font-bold text-gray-800 max-sm:text-base"
                    >
                        ${{ item.product.price }}
                    </h4>

                    <div
                        class="flex items-center gap-2 mt-6 text-xs text-gray-800 bg-transparent border border-gray-300 rounded-md outline-none"
                    >
                        <button
                            class="p-2"
                            type="button"
                            @click="store.decreaseProductQuantity(item.product)"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-2.5 fill-current"
                                viewBox="0 0 124 124"
                            >
                                <path
                                    d="M112 50H12C5.4 50 0 55.4 0 62s5.4 12 12 12h100c6.6 0 12-5.4 12-12s-5.4-12-12-12z"
                                    data-original="#000000"
                                />
                            </svg>
                        </button>

                        <span class="font-bold">
                            {{ item.quantity }}
                        </span>

                        <button
                            class="p-2"
                            type="button"
                            @click="store.increaseProductQuantity(item.product)"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-2.5 fill-current"
                                viewBox="0 0 42 42"
                            >
                                <path
                                    d="M37.059 16H26V4.941C26 2.224 23.718 0 21 0s-5 2.224-5 4.941V16H4.941C2.224 16 0 18.282 0 21s2.224 5 4.941 5H16v11.059C16 39.776 18.282 42 21 42s5-2.224 5-4.941V26h11.059C39.776 26 42 23.718 42 21s-2.224-5-4.941-5z"
                                    data-original="#000000"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gray-100 rounded-md h-max">
            <h3
                class="pb-2 text-lg font-bold text-gray-800 border-b border-gray-300 max-sm:text-base"
            >
                Order Summary
            </h3>

            <form class="mt-6">
                <div>
                    <h3 class="mb-4 text-base font-semibold text-gray-800">
                        Enter Details
                    </h3>
                    <div class="space-y-3">
                        <div class="relative flex items-center">
                            <input
                                v-model="name"
                                type="text"
                                required
                                placeholder="Full Name"
                                :disabled="store.totalItems === 0"
                                class="px-4 py-2.5 bg-white text-gray-800 disabled:bg-gray-200 disabled:text-gray-400 rounded-md w-full text-sm border-b focus:border-yellow-500 outline-none"
                            />
                            <u-icon
                                name="material-symbols:person"
                                size="20"
                                class="absolute right-4"
                            />
                        </div>

                        <div class="relative flex items-center">
                            <input
                                v-model="email"
                                type="email"
                                required
                                placeholder="Email"
                                :disabled="store.totalItems === 0"
                                class="px-4 py-2.5 bg-white text-gray-800 rounded-md disabled:bg-gray-200 disabled:text-gray-400 w-full text-sm border-b focus:border-yellow-500 outline-none"
                            />
                            <u-icon
                                name="material-symbols:mail"
                                size="20"
                                class="absolute right-4"
                            />
                        </div>

                        <div class="relative flex items-center">
                            <input
                                v-model="phone"
                                type="text"
                                required
                                placeholder="Phone No."
                                :disabled="store.totalItems === 0"
                                class="px-4 py-2.5 bg-white text-gray-800 rounded-md disabled:bg-gray-200 disabled:text-gray-400 w-full text-sm border-b focus:border-yellow-500 outline-none"
                            />
                            <u-icon
                                name="material-symbols:phone-enabled"
                                size="20"
                                class="absolute right-4"
                            />
                        </div>
                    </div>
                </div>
            </form>

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
                    type="button"
                    color="orange"
                    :disabled="store.totalItems === 0"
                    class="text-sm flex justify-center gap-1 px-4 py-2.5 w-full font-semibold disabled:opacity-75 tracking-wide text-gray-800 rounded-md"
                    @click="checkout"
                >
                    <u-icon name="material-symbols:shopping-cart" size="20" />
                    Checkout
                </u-button>

                <nuxt-link
                    to="/"
                    type="button"
                    class="flex justify-center text-center text-sm px-4 py-2.5 w-full border-2 font-semibold tracking-wide bg-transparent text-gray-800 border-yellow-500 rounded-md hover:bg-orange-400 hover:border-orange-400"
                >
                    <u-icon name="ic:round-keyboard-arrow-left" size="20" />
                    Continue Shopping
                </nuxt-link>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
onMounted(() => {
    calculateOrder();
});

const store = useCartStore();

const name = ref('');
const email = ref('');
const phone = ref('');

const subTotal = ref(0);
const shipping = ref(0);
const tax = ref(0);
const total = ref(0);

function calculateOrder() {
    subTotal.value = store.totalPrice;

    shipping.value = Math.round(0.05 * subTotal.value * 100) / 100;
    tax.value = Math.round(0.1 * subTotal.value * 100) / 100;
    total.value =
        Math.round((subTotal.value + shipping.value + tax.value) * 100) / 100;
}

function clearDetails() {
    name.value = '';
    email.value = '';
    phone.value = '';
}

watch(store.items, () => {
    calculateOrder();
});

const { $notify } = useNuxtApp();
const checkout = async () => {
    if (name.value === '' || email.value === '' || phone.value === '') {
        $notify('Please fill all the details', 'warning');
        return;
    }

    const apiUrl: string = useRuntimeConfig().public.apiUrl;

    const { data } = await useFetch(`${apiUrl}/v1/orders`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
        },
        body: {
            products: store.items,
            total: total.value,
            details: {
                name: name.value,
                email: email.value,
                phone: phone.value,
            },
        },
    });

    if (!data.value) {
        $notify('Something went wrong', 'error');
        return;
    }

    store.clearCart();
    calculateOrder();
    clearDetails();

    $notify('Order Placed Successfully');
};
</script>
