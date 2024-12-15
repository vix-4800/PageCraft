<template>
    <main>
        <div class="max-w-xl p-4 mx-auto font-sans lg:max-w-7xl">
            <div class="grid items-start grid-cols-1 gap-12 lg:grid-cols-5">
                <div
                    class="top-0 w-full p-6 bg-gray-100 border border-orange-300 rounded-lg lg:col-span-3 lg:sticky"
                >
                    <div
                        class="flex items-center justify-center p-2 bg-white rounded-xl"
                    >
                        <UCarousel
                            ref="carouselRef"
                            v-slot="{ item }"
                            class="overflow-hidden rounded-lg"
                            :items="[product.image]"
                            :ui="{ item: 'basis-full' }"
                        >
                            <img :src="item" class="w-full" draggable="false" />
                        </UCarousel>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ product.name }}
                    </h2>

                    <div class="flex mt-2">
                        <u-icon
                            v-for="i in averageRating"
                            :key="i"
                            name="line-md:star-alt-filled"
                            size="30"
                            class="bg-orange-400"
                        />

                        <u-icon
                            v-for="i in 5 - averageRating"
                            :key="i"
                            name="line-md:star-alt-filled"
                            size="30"
                            class="bg-gray-400"
                        />
                    </div>

                    <div class="mt-6">
                        <h3 class="text-xl font-bold text-gray-800">
                            About the Product
                        </h3>
                        <ul
                            class="mt-2 space-y-3 text-sm text-gray-800 list-disc"
                        >
                            {{
                                product.description
                            }}
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4 mt-6">
                        <h3 class="text-xl font-bold text-gray-800">
                            Product Variations
                        </h3>

                        <div
                            class="flex flex-wrap justify-center mx-auto gap-x-4"
                        >
                            <UChip
                                v-for="variation in variations"
                                :key="variation.sku"
                                :text="variation.stock"
                                size="2xl"
                            >
                                <button
                                    type="button"
                                    class="p-2 bg-white border-2 border-gray-200 rounded-lg"
                                    :class="
                                        variation.sku === selectedVariation.sku
                                            ? 'border-orange-400'
                                            : ''
                                    "
                                    @click="selectedVariation.value = variation"
                                >
                                    <div class="w-12 h-12">
                                        <img
                                            :src="variation.image"
                                            alt="Product1"
                                            class="w-full h-full"
                                        />
                                    </div>
                                </button>
                            </UChip>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-800">
                                Product Specifications
                            </h3>
                            <ul
                                class="mt-2 ml-4 space-y-1 text-sm text-gray-800 list-disc"
                            >
                                <li
                                    v-for="(
                                        attribute, key
                                    ) in selectedVariation.attributes"
                                    :key="key"
                                >
                                    {{
                                        attribute.name.charAt(0).toUpperCase() +
                                        attribute.name.slice(1)
                                    }}:
                                    {{
                                        attribute.value
                                            .charAt(0)
                                            .toUpperCase() +
                                        attribute.value.slice(1)
                                    }}
                                </li>
                            </ul>
                        </div>

                        <button
                            type="button"
                            class="flex items-center justify-center w-full gap-2 px-6 py-3 text-sm font-semibold text-white bg-orange-400 rounded-md hover:bg-orange-500"
                            :disabled="
                                selectedVariation === null ||
                                selectedVariation.stock === 0
                            "
                            @click="addToCart"
                        >
                            <u-icon
                                name="material-symbols:add-shopping-cart-sharp"
                                size="20"
                            />
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-800">
                    Reviews ({{ reviews.length }})
                </h3>

                <div class="w-1/2 mt-4 space-y-3">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-bold text-gray-800">5.0</p>
                        <u-icon
                            name="material-symbols:star"
                            size="20"
                            class="bg-orange-600"
                        />
                        <u-meter
                            :value="
                                reviews.length > 0
                                    ? (fiveStarReviews / reviews.length) * 100
                                    : 0
                            "
                            color="orange"
                        />
                        <p class="text-sm font-bold text-gray-800">
                            {{ fiveStarReviews }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-sm font-bold text-gray-800">4.0</p>
                        <u-icon
                            name="material-symbols:star"
                            size="20"
                            class="bg-orange-600"
                        />
                        <u-meter
                            :value="
                                reviews.length > 0
                                    ? (fourStarReviews / reviews.length) * 100
                                    : 0
                            "
                            color="orange"
                        />
                        <p class="text-sm font-bold text-gray-800">
                            {{ fourStarReviews }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-sm font-bold text-gray-800">3.0</p>
                        <u-icon
                            name="material-symbols:star"
                            size="20"
                            class="bg-orange-600"
                        />
                        <u-meter
                            :value="
                                reviews.length > 0
                                    ? (threeStarReviews / reviews.length) * 100
                                    : 0
                            "
                            color="orange"
                        />
                        <p class="text-sm font-bold text-gray-800">
                            {{ threeStarReviews }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-sm font-bold text-gray-800">2.0</p>
                        <u-icon
                            name="material-symbols:star"
                            size="20"
                            class="bg-orange-600"
                        />
                        <u-meter
                            :value="
                                reviews.length > 0
                                    ? (twoStarReviews / reviews.length) * 100
                                    : 0
                            "
                            color="orange"
                        />
                        <p class="text-sm font-bold text-gray-800">
                            {{ twoStarReviews }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-sm font-bold text-gray-800">1.0</p>
                        <u-icon
                            name="material-symbols:star"
                            size="20"
                            class="bg-orange-600"
                        />
                        <u-meter
                            :value="
                                reviews.length > 0
                                    ? (oneStarReviews / reviews.length) * 100
                                    : 0
                            "
                            color="orange"
                        />
                        <p class="text-sm font-bold text-gray-800">
                            {{ oneStarReviews }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col items-start gap-8 mt-8">
                    <div
                        v-for="review in reviews"
                        :key="review.id"
                        class="flex"
                    >
                        <img
                            :src="review.user?.image"
                            class="w-12 h-12 border-2 border-white rounded-full"
                        />
                        <div class="ml-3">
                            <h4 class="text-sm font-bold">
                                {{ review.user?.name }}
                            </h4>
                            <div class="flex items-center mt-1">
                                <u-icon
                                    v-for="i in review.rating"
                                    :key="i"
                                    name="line-md:star-alt-filled"
                                    size="20"
                                    class="bg-orange-400"
                                />
                                <u-icon
                                    v-for="i in 5 - review.rating"
                                    :key="i"
                                    name="line-md:star-alt-filled"
                                    size="20"
                                    class="bg-gray-400"
                                />
                                <p class="text-xs !ml-2 font-semibold">
                                    {{ review.created_at }}
                                </p>
                            </div>
                            <p class="mt-2 text-xs">
                                {{ review.text }}
                            </p>
                        </div>
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
const reviews = ref([]);

const fiveStarReviews = ref(0);
const fourStarReviews = ref(0);
const threeStarReviews = ref(0);
const twoStarReviews = ref(0);
const oneStarReviews = ref(0);
const averageRating = ref(0);

const carouselRef = ref();

onMounted(async () => {
    setInterval(() => {
        if (!carouselRef.value) return;

        if (carouselRef.value.page === carouselRef.value.pages)
            return carouselRef.value.select(0);

        carouselRef.value.next();
    }, 3000);

    const response: { data: Product } = await $fetch<{ data: Product[] }>(
        `${apiUrl}/v1/products/${useRoute().params.slug}`,
        {
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
        }
    );

    product.value = response.data;
    variations.value = product.value.variations;
    selectedVariation.value = variations.value[0];

    const response2 = await $fetch(
        `${apiUrl}/v1/products/${useRoute().params.slug}/reviews`,
        {
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
        }
    );

    reviews.value = response2.data;

    if (reviews.value.length > 0) {
        reviews.value.forEach((review) => {
            if (review.rating === 5) fiveStarReviews.value++;
            if (review.rating === 4) fourStarReviews.value++;
            if (review.rating === 3) threeStarReviews.value++;
            if (review.rating === 2) twoStarReviews.value++;
            if (review.rating === 1) oneStarReviews.value++;
        });

        averageRating.value = Math.round(
            (fiveStarReviews.value * 5 +
                fourStarReviews.value * 4 +
                threeStarReviews.value * 3 +
                twoStarReviews.value * 2 +
                oneStarReviews.value) /
                reviews.value.length
        );
    }
});

const { $notify } = useNuxtApp();
const addToCart = () => {
    useCartStore().increaseProductQuantity(selectedVariation.value);

    $notify(`${product.value.name} added to cart`, 'info');
};
</script>
