<template>
    <div
        class="font-[sans-serif] py-4 mx-auto lg:max-w-6xl max-w-lg md:max-w-full"
    >
        <h2 class="mb-6 text-4xl font-extrabold text-gray-800">Our Products</h2>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="product in products"
                :key="product.slug"
                class="bg-gray-200 rounded-xl flex flex-col hover:scale-[1.03] transition-all relative overflow-hidden"
            >
                <div class="p-5">
                    <div
                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16px"
                            class="inline-block fill-gray-800"
                            viewBox="0 0 64 64"
                        >
                            <path
                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                data-original="#000000"
                            />
                        </svg>
                    </div>

                    <div
                        class="h-[220px] rounded-lg p-3 overflow-hidden mx-auto cursor-pointer bg-white"
                    >
                        <nuxt-link :to="`/products/${product.slug}`">
                            <img
                                :src="product.image"
                                :alt="product.name"
                                class="object-contain w-full h-full"
                            />
                        </nuxt-link>
                    </div>
                </div>

                <div
                    class="flex flex-col gap-3 p-6 text-center bg-gray-100 h-1/2"
                >
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ product.name }}
                    </h3>
                    <p class="text-gray-600 text-md">
                        {{ product.description }}
                    </p>

                    <nuxt-link
                        :to="`/products/${product.slug}`"
                        class="flex items-center justify-center w-full gap-3 px-6 py-3 mt-auto text-base font-semibold text-gray-800 bg-yellow-400 rounded-xl"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20px"
                            height="20px"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                                data-original="#000000"
                            />
                        </svg>
                        View
                    </nuxt-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';

defineProps({
    products: {
        type: Array as () => Product[],
        required: true,
    },
});
</script>
