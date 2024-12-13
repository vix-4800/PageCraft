<template>
    <main>
        <div class="max-w-xl p-4 mx-auto font-sans lg:max-w-7xl">
            <div class="grid items-start grid-cols-1 gap-12 lg:grid-cols-5">
                <div
                    class="min-h-[500px] bg-gray-100 border border-orange-300 lg:col-span-3 rounded-lg w-full lg:sticky top-0 text-center p-6"
                >
                    <div
                        class="flex items-center justify-center bg-white rounded-xl"
                    >
                        <img
                            :src="product.image"
                            alt="Product"
                            class="object-cover w-3/5 py-6 rounded"
                        />
                    </div>

                    <hr class="my-6 border border-orange-300" />

                    <div
                        class="flex flex-wrap justify-center mx-auto gap-x-4 gap-y-6"
                    >
                        <div
                            class="w-20 h-20 p-3 bg-white rounded-lg max-lg:w-16 max-lg:h-16"
                        >
                            <img
                                src="https://readymadeui.com/images/coffee6.webp"
                                alt="Product1"
                                class="w-full h-full cursor-pointer"
                            />
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ product.name }}
                    </h2>

                    <div class="flex mt-2">
                        <u-icon
                            name="material-symbols:star"
                            size="30"
                            class="bg-orange-400"
                        />
                        <u-icon
                            name="material-symbols:star"
                            size="30"
                            class="bg-orange-400"
                        />
                        <u-icon
                            name="material-symbols:star"
                            size="30"
                            class="bg-orange-400"
                        />
                        <u-icon
                            name="material-symbols:star"
                            size="30"
                            class="bg-orange-400"
                        />
                        <u-icon
                            name="material-symbols:star"
                            size="30"
                            class="bg-gray-400"
                        />
                    </div>

                    <div class="mt-6">
                        <h3 class="text-xl font-bold text-gray-800">
                            About the Product
                        </h3>
                        <ul
                            class="mt-4 space-y-3 text-sm text-gray-800 list-disc"
                        >
                            {{
                                product.description
                            }}
                        </ul>
                    </div>

                    <div
                        class="flex flex-wrap justify-center mx-auto mt-6 gap-x-4"
                    >
                        <button
                            v-for="variation in variations"
                            :key="variation.sku"
                            type="button"
                            class="p-2 bg-white border-2 border-gray-200 rounded-lg"
                            :class="
                                variation.sku === selectedVariation.sku
                                    ? 'border-orange-400'
                                    : ''
                            "
                            @click="selectVariant(variation)"
                        >
                            <div class="w-12 h-12">
                                <img
                                    :src="variation.image"
                                    alt="Product1"
                                    class="w-full h-full"
                                />
                            </div>
                        </button>
                    </div>

                    <button
                        type="button"
                        class="flex items-center justify-center w-full gap-2 px-6 py-3 mt-6 text-sm font-semibold text-white bg-orange-400 rounded-md hover:bg-orange-500"
                        :disabled="selectedVariation === null"
                        @click="addToCart"
                    >
                        <u-icon
                            name="material-symbols:add-shopping-cart-sharp"
                            size="20"
                        />
                        Add to cart
                    </button>

                    <div class="mt-8">
                        <h3 class="text-xl font-bold text-gray-800">
                            Reviews (10)
                        </h3>
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-gray-800">
                                    5.0
                                </p>
                                <u-icon
                                    name="material-symbols:star"
                                    size="20"
                                    class="bg-orange-400"
                                />
                                <div class="w-full h-2 bg-gray-300 rounded">
                                    <div
                                        class="w-2/3 h-full bg-orange-400 rounded"
                                    ></div>
                                </div>
                                <p class="text-sm font-bold text-gray-800">
                                    66%
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-gray-800">
                                    4.0
                                </p>
                                <u-icon
                                    name="material-symbols:star"
                                    size="20"
                                    class="bg-orange-400"
                                />
                                <div class="w-full h-2 bg-gray-300 rounded">
                                    <div
                                        class="w-1/3 h-full bg-orange-400 rounded"
                                    ></div>
                                </div>
                                <p class="text-sm font-bold text-gray-800">
                                    33%
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-gray-800">
                                    3.0
                                </p>
                                <u-icon
                                    name="material-symbols:star"
                                    size="20"
                                    class="bg-orange-400"
                                />
                                <div class="w-full h-2 bg-gray-300 rounded">
                                    <div
                                        class="w-1/6 h-full bg-orange-400 rounded"
                                    ></div>
                                </div>
                                <p class="text-sm font-bold text-gray-800">
                                    16%
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-gray-800">
                                    2.0
                                </p>
                                <u-icon
                                    name="material-symbols:star"
                                    size="20"
                                    class="bg-orange-400"
                                />
                                <div class="w-full h-2 bg-gray-300 rounded">
                                    <div
                                        class="w-1/12 h-full bg-orange-400 rounded"
                                    ></div>
                                </div>
                                <p class="text-sm font-bold text-gray-800">
                                    8%
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-gray-800">
                                    1.0
                                </p>
                                <u-icon
                                    name="material-symbols:star"
                                    size="20"
                                    class="bg-orange-400"
                                />
                                <div class="w-full h-2 bg-gray-300 rounded">
                                    <div
                                        class="w-[6%] h-full rounded bg-orange-400"
                                    ></div>
                                </div>
                                <p class="text-sm font-bold text-gray-800">
                                    6%
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start mt-8">
                            <img
                                src="https://readymadeui.com/team-2.webp"
                                class="w-12 h-12 border-2 border-white rounded-full"
                            />
                            <div class="ml-3">
                                <h4 class="text-sm font-bold">John Doe</h4>
                                <div class="flex items-center mt-1">
                                    <u-icon
                                        name="material-symbols:star"
                                        size="20"
                                        class="bg-orange-400"
                                    />
                                    <u-icon
                                        name="material-symbols:star"
                                        size="20"
                                        class="bg-orange-400"
                                    />
                                    <u-icon
                                        name="material-symbols:star"
                                        size="20"
                                        class="bg-orange-400"
                                    />
                                    <u-icon
                                        name="material-symbols:star"
                                        size="20"
                                        class="bg-orange-400"
                                    />
                                    <u-icon
                                        name="material-symbols:star"
                                        size="20"
                                        class="bg-orange-400"
                                    />
                                    <p class="text-xs !ml-2 font-semibold">
                                        2 mins ago
                                    </p>
                                </div>
                                <p class="mt-4 text-xs">
                                    The service was amazing. I never had to wait
                                    that long for my food. The staff was
                                    friendly and attentive, and the delivery was
                                    impressively prompt.
                                </p>
                            </div>
                        </div>
                        <button
                            type="button"
                            class="w-full mt-8 px-4 py-2.5 bg-transparent border border-orange-400 text-gray-800 font-semibold rounded-lg"
                        >
                            Read all reviews
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';
import type { ProductVariant } from '~/types/product_variant';

const apiUrl: string = useRuntimeConfig().public.apiUrl;

const product = ref<Product>({});
const variations = ref<ProductVariant[]>([]);
const selectedVariation = ref<ProductVariant>({});
onMounted(async () => {
    const response: { data: Product } = await $fetch<{ data: Product[] }>(
        `${apiUrl}/v1/product-by-slug/${useRoute().params.slug}`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
        }
    ).catch((error) => error.data);

    product.value = response.data;
    variations.value = product.value.variations;
    selectedVariation.value = variations.value[0];
});

const selectVariant = (variant: ProductVariant) => {
    selectedVariation.value = variant;
};

const addToCart = () => {
    useCartStore().increaseProductQuantity(selectedVariation.value);
};
</script>
