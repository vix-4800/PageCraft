<template>
    <div class="max-w-5xl py-4 mx-auto font-sans bg-white max-md:max-w-xl">
        <h1 class="text-3xl font-bold text-center text-gray-800">
            Shopping Cart
        </h1>

        <div class="grid gap-8 mt-16 md:grid-cols-3">
            <div class="space-y-4 md:col-span-2">
                <div
                    v-for="item in items"
                    :key="item.product.slug"
                    class="grid items-start grid-cols-3 gap-4 pb-4 border-b border-gray-300"
                >
                    <div class="flex items-start col-span-2 gap-4">
                        <div
                            class="p-2 bg-white border-2 border-gray-300 rounded-md w-28 h-28 max-sm:w-24 max-sm:h-24 shrink-0"
                        >
                            <img
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
                                @click="removeProduct(item.product)"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="inline w-4 fill-current"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z"
                                        data-original="#000000"
                                    />
                                    <path
                                        d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z"
                                        data-original="#000000"
                                    />
                                </svg>
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
                                @click="decrementQuantity(item.product)"
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
                                @click="incrementQuantity(item.product)"
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
                                    type="text"
                                    placeholder="Full Name"
                                    :disabled="store.totalItems === 0"
                                    class="px-4 py-2.5 bg-white text-gray-800 disabled:bg-gray-200 disabled:text-gray-400 rounded-md w-full text-sm border-b focus:border-yellow-500 outline-none"
                                />
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="#bbb"
                                    stroke="#bbb"
                                    class="absolute w-4 h-4 right-4"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="10"
                                        cy="7"
                                        r="6"
                                        data-original="#000000"
                                    />
                                    <path
                                        d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"
                                        data-original="#000000"
                                    />
                                </svg>
                            </div>

                            <div class="relative flex items-center">
                                <input
                                    type="email"
                                    placeholder="Email"
                                    :disabled="store.totalItems === 0"
                                    class="px-4 py-2.5 bg-white text-gray-800 rounded-md disabled:bg-gray-200 disabled:text-gray-400 w-full text-sm border-b focus:border-yellow-500 outline-none"
                                />
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="#bbb"
                                    stroke="#bbb"
                                    class="absolute w-4 h-4 right-4"
                                    viewBox="0 0 682.667 682.667"
                                >
                                    <defs>
                                        <clipPath
                                            id="a"
                                            clipPathUnits="userSpaceOnUse"
                                        >
                                            <path
                                                d="M0 512h512V0H0Z"
                                                data-original="#000000"
                                            />
                                        </clipPath>
                                    </defs>
                                    <g
                                        clip-path="url(#a)"
                                        transform="matrix(1.33 0 0 -1.33 0 682.667)"
                                    >
                                        <path
                                            fill="none"
                                            stroke-miterlimit="10"
                                            stroke-width="40"
                                            d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z"
                                            data-original="#000000"
                                        />
                                        <path
                                            d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z"
                                            data-original="#000000"
                                        />
                                    </g>
                                </svg>
                            </div>

                            <div class="relative flex items-center">
                                <input
                                    type="number"
                                    placeholder="Phone No."
                                    :disabled="store.totalItems === 0"
                                    class="px-4 py-2.5 bg-white text-gray-800 rounded-md disabled:bg-gray-200 disabled:text-gray-400 w-full text-sm border-b focus:border-yellow-500 outline-none"
                                />
                                <svg
                                    fill="#bbb"
                                    class="absolute w-4 h-4 right-4"
                                    viewBox="0 0 64 64"
                                >
                                    <path
                                        d="m52.148 42.678-6.479-4.527a5 5 0 0 0-6.963 1.238l-1.504 2.156c-2.52-1.69-5.333-4.05-8.014-6.732-2.68-2.68-5.04-5.493-6.73-8.013l2.154-1.504a4.96 4.96 0 0 0 2.064-3.225 4.98 4.98 0 0 0-.826-3.739l-4.525-6.478C20.378 10.5 18.85 9.69 17.24 9.69a4.69 4.69 0 0 0-1.628.291 8.97 8.97 0 0 0-1.685.828l-.895.63a6.782 6.782 0 0 0-.63.563c-1.092 1.09-1.866 2.472-2.303 4.104-1.865 6.99 2.754 17.561 11.495 26.301 7.34 7.34 16.157 11.9 23.011 11.9 1.175 0 2.281-.136 3.29-.406 1.633-.436 3.014-1.21 4.105-2.302.199-.199.388-.407.591-.67l.63-.899a9.007 9.007 0 0 0 .798-1.64c.763-2.06-.007-4.41-1.871-5.713z"
                                        data-original="#000000"
                                    />
                                </svg>
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
                    <button
                        type="button"
                        :disabled="store.totalItems === 0"
                        class="text-sm px-4 py-2.5 w-full font-semibold disabled:opacity-75 tracking-wide bg-yellow-500 disabled:hover:bg-yellow-500 disabled:hover:border-yellow-500 hover:bg-orange-400 text-gray-800 rounded-md border-2 border-yellow-500 hover:border-orange-400"
                    >
                        Checkout
                    </button>

                    <nuxt-link
                        to="/"
                        type="button"
                        class="block text-center text-sm px-4 py-2.5 w-full border-2 font-semibold tracking-wide bg-transparent text-gray-800 border-yellow-500 rounded-md hover:bg-orange-400 hover:border-orange-400"
                    >
                        Continue Shopping
                    </nuxt-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { ProductVariant } from '~/types/product_variant';

onMounted(() => {
    calculateOrder();
});

const store = useCartStore();

const items = ref(store.items);

const subTotal = ref(0);
const shipping = ref(0);
const tax = ref(0);
const total = ref(0);

const incrementQuantity = (item: ProductVariant) => {
    store.increaseProductQuantity(item);
    calculateOrder();
};

const decrementQuantity = (item: ProductVariant) => {
    store.decreaseProductQuantity(item);
    calculateOrder();
};

const removeProduct = (item: ProductVariant) => {
    store.removeProduct(item);
    calculateOrder();
};

const calculateOrder = () => {
    subTotal.value = store.totalPrice;

    shipping.value = Math.round(0.05 * subTotal.value * 100) / 100;
    tax.value = Math.round(0.1 * subTotal.value * 100) / 100;
    total.value =
        Math.round((subTotal.value + shipping.value + tax.value) * 100) / 100;
};
</script>
