<template>
    <div v-if="product !== null" class="font-[sans-serif] p-4">
        <div class="max-w-xl mx-auto lg:max-w-6xl">
            <div
                class="grid items-start grid-cols-1 gap-8 lg:grid-cols-2 max-lg:gap-12 max-sm:gap-8"
            >
                <div class="top-0 w-full lg:sticky">
                    <div class="flex flex-row gap-2">
                        <div
                            class="flex flex-col w-16 gap-2 max-sm:w-14 shrink-0"
                        >
                            <u-button
                                :padded="false"
                                @click="selectedImage = product.image"
                            >
                                <nuxt-img
                                    :src="product.image"
                                    :alt="product.name"
                                    class="aspect-[64/85] w-full cursor-pointer border-b-2 border-black"
                                />
                            </u-button>
                            <u-button
                                v-for="image in product.additional_images"
                                :key="image"
                                :padded="false"
                                :ui="{ rounded: 'rounded-lg' }"
                                @click="selectedImage = image"
                            >
                                <nuxt-img
                                    :src="image"
                                    :alt="product.name"
                                    class="aspect-[64/85] w-full cursor-pointer border-b-2 border-black"
                                />
                            </u-button>
                        </div>
                        <div class="flex-1">
                            <nuxt-img
                                :src="selectedImage"
                                :alt="product.name"
                                class="w-full aspect-[548/712] object-cover"
                            />
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 sm:text-xl">
                            {{ product.name }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ product.description }}
                        </p>
                        <div class="flex flex-wrap items-center gap-4 mt-4">
                            <h4
                                v-if="selectedVariation !== null"
                                class="text-2xl font-bold text-gray-800 sm:text-3xl"
                            >
                                ${{ selectedVariation.price }}
                            </h4>
                        </div>

                        <div class="flex items-center gap-4 mt-2">
                            <div
                                class="flex items-center gap-1 text-lg px-2.5 bg-green-600 text-white rounded-full"
                            >
                                <p>{{ averageRating }}</p>
                                <svg
                                    class="w-[13px] h-[13px] fill-white"
                                    viewBox="0 0 14 13"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z"
                                    />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500">
                                {{ reviews.length }} reviews
                            </p>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300" />

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 sm:text-xl">
                            Sizes
                        </h3>
                        <div class="flex flex-wrap gap-4 mt-4">
                            <button
                                type="button"
                                class="flex items-center justify-center w-10 text-sm border border-gray-300 h-9 hover:border-blue-600 shrink-0"
                            >
                                SM
                            </button>
                            <button
                                type="button"
                                class="flex items-center justify-center w-10 text-sm border border-blue-600 h-9 hover:border-blue-600 shrink-0"
                            >
                                MD
                            </button>
                            <button
                                type="button"
                                class="flex items-center justify-center w-10 text-sm border border-gray-300 h-9 hover:border-blue-600 shrink-0"
                            >
                                LG
                            </button>
                            <button
                                type="button"
                                class="flex items-center justify-center w-10 text-sm border border-gray-300 h-9 hover:border-blue-600 shrink-0"
                            >
                                XL
                            </button>
                        </div>

                        <div class="flex flex-wrap gap-4 mt-6">
                            <u-button
                                block
                                class="px-4 py-3 w-[45%] border text-gray-800 text-sm font-semibold"
                                :label="
                                    favoriteStore.isFavorite(product)
                                        ? 'Remove from wishlist'
                                        : 'Add to wishlist'
                                "
                                :class="{
                                    'bg-red-200 hover:bg-red-300 border-red-400':
                                        favoriteStore.isFavorite(product),
                                    'bg-gray-100 hover:bg-gray-200 border-gray-300':
                                        !favoriteStore.isFavorite(product),
                                }"
                                @click="favoriteStore.toggleFavorite(product)"
                            />
                            <u-button
                                :disabled="
                                    selectedVariation === null ||
                                    selectedVariation.stock === 0
                                "
                                :label="
                                    cartStore.isProductInCart(selectedVariation)
                                        ? 'Go to cart'
                                        : 'Add to cart'
                                "
                                block
                                class="px-4 py-3 w-[45%] border text-sm font-semibold"
                                :to="
                                    cartStore.isProductInCart(selectedVariation)
                                        ? '/cart'
                                        : ''
                                "
                                :class="{
                                    'bg-green-100 hover:bg-green-200 border-green-300 text-green-800':
                                        cartStore.isProductInCart(
                                            selectedVariation
                                        ),
                                    'border-blue-600 bg-blue-600 hover:bg-blue-700 text-white':
                                        !cartStore.isProductInCart(
                                            selectedVariation
                                        ),
                                }"
                                @click="addToCart"
                            />
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300" />

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 sm:text-xl">
                            Product Information
                        </h3>
                        <div class="mt-2" role="accordion">
                            <div class="transition-all hover:bg-gray-100">
                                <button
                                    type="button"
                                    class="w-full text-sm font-semibold text-left px-4 py-2.5 text-gray-800 flex items-center"
                                >
                                    <span class="mr-4">Vendor details</span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-3 h-3 ml-auto -rotate-90 fill-current shrink-0"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M11.99997 18.1669a2.38 2.38 0 0 1-1.68266-.69733l-9.52-9.52a2.38 2.38 0 1 1 3.36532-3.36532l7.83734 7.83734 7.83734-7.83734a2.38 2.38 0 1 1 3.36532 3.36532l-9.52 9.52a2.38 2.38 0 0 1-1.68266.69734z"
                                            clip-rule="evenodd"
                                            data-original="#000000"
                                        />
                                    </svg>
                                </button>
                                <div class="hidden px-4 pb-4">
                                    <p
                                        class="text-sm leading-relaxed text-gray-500"
                                    >
                                        Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit. Sed do eiusmod tempor
                                        incididunt ut labore et dolore magna
                                        aliqua.
                                    </p>
                                </div>
                            </div>

                            <div class="transition-all hover:bg-gray-100">
                                <button
                                    type="button"
                                    class="w-full text-sm font-semibold text-left px-4 py-2.5 text-gray-800 flex items-center"
                                >
                                    <span class="mr-4">
                                        Return and exchange policy
                                    </span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-3 h-3 ml-auto -rotate-90 fill-current shrink-0"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M11.99997 18.1669a2.38 2.38 0 0 1-1.68266-.69733l-9.52-9.52a2.38 2.38 0 1 1 3.36532-3.36532l7.83734 7.83734 7.83734-7.83734a2.38 2.38 0 1 1 3.36532 3.36532l-9.52 9.52a2.38 2.38 0 0 1-1.68266.69734z"
                                            clip-rule="evenodd"
                                            data-original="#000000"
                                        />
                                    </svg>
                                </button>
                                <div class="hidden px-4 pb-4">
                                    <p
                                        class="text-sm leading-relaxed text-gray-500"
                                    >
                                        Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit. Sed do eiusmod tempor
                                        incididunt ut labore et dolore magna
                                        aliqua.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300" />

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 sm:text-xl">
                            Customer Reviews
                        </h3>
                        <div class="flex items-center gap-1.5 mt-4">
                            <svg
                                v-for="n in Math.round(averageRating)"
                                :key="n"
                                class="w-5 h-5 fill-blue-600"
                                viewBox="0 0 14 13"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z"
                                />
                            </svg>
                            <svg
                                v-for="n in 5 - Math.round(averageRating)"
                                :key="n"
                                class="w-5 h-5 fill-[#CED5D8]"
                                viewBox="0 0 14 13"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z"
                                />
                            </svg>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 mt-4">
                            <h4
                                class="text-2xl font-semibold text-gray-800 sm:text-3xl"
                            >
                                {{ averageRating }} / 5
                            </h4>
                            <p class="text-sm text-gray-500">
                                Based on {{ reviews.length }} ratings
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div
                            v-for="review in reviews"
                            :key="review.id"
                            class="flex items-start"
                        >
                            <nuxt-img
                                :src="review.user?.avatar || '/placeholder.png'"
                                class="w-12 h-12 border-2 border-gray-300 rounded-full"
                            />
                            <div class="ml-3">
                                <h4 class="text-sm font-bold">
                                    {{ review.user?.name }}
                                </h4>
                                <div class="flex mt-1 space-x-1">
                                    <svg
                                        v-for="i in review.rating"
                                        :key="i"
                                        class="w-[14px] h-[14px] fill-blue-600"
                                        viewBox="0 0 14 13"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z"
                                        />
                                    </svg>
                                    <svg
                                        v-for="i in 5 - review.rating"
                                        :key="i"
                                        class="w-[14px] h-[14px] fill-[#CED5D8]"
                                        viewBox="0 0 14 13"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z"
                                        />
                                    </svg>
                                    <p class="text-xs text-gray-500 !ml-2">
                                        {{
                                            new Date(
                                                review.created_at
                                            ).toLocaleString()
                                        }}
                                    </p>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ review.text }}
                                </p>
                            </div>
                        </div>

                        <a
                            href="javascript:void(0)"
                            class="block mt-6 text-sm font-semibold text-blue-600 hover:underline"
                        >
                            Read all reviews
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product, ProductVariation } from '~/types/product';
import type { Review } from '~/types/review';

const cartStore = useCartStore();
const favoriteStore = useFavoriteStore();

const props = defineProps({
    product: {
        type: Object as () => Product,
        required: true,
    },
    variations: {
        type: Array as () => ProductVariation[],
        required: true,
    },
    reviews: {
        type: Array as () => Review[],
        required: true,
    },
});

const fiveStarReviews = ref(0);
const fourStarReviews = ref(0);
const threeStarReviews = ref(0);
const twoStarReviews = ref(0);
const oneStarReviews = ref(0);
const averageRating = ref(0);

const selectedVariation = ref<ProductVariation | null>(null);
const selectedImage = ref<string | null>(null);

watch(
    () => props.product,
    (newProduct) => {
        if (newProduct !== null) {
            selectedImage.value = newProduct.image;
        }
    },
    { immediate: true }
);

watch(
    () => props.variations,
    (newVariations) => {
        if (newVariations.length > 0 && !selectedVariation.value) {
            selectedVariation.value = newVariations[0];
        }
    },
    { immediate: true }
);

watch(
    () => props.reviews,
    (newReviews) => {
        if (newReviews.length > 0) {
            newReviews.forEach((review: Review) => {
                if (review.rating === 5) fiveStarReviews.value++;
                if (review.rating === 4) fourStarReviews.value++;
                if (review.rating === 3) threeStarReviews.value++;
                if (review.rating === 2) twoStarReviews.value++;
                if (review.rating === 1) oneStarReviews.value++;
            });

            averageRating.value = Number(
                (
                    (fiveStarReviews.value * 5 +
                        fourStarReviews.value * 4 +
                        threeStarReviews.value * 3 +
                        twoStarReviews.value * 2 +
                        oneStarReviews.value) /
                    newReviews.length
                ).toFixed(2)
            );
        }
    },
    { immediate: true }
);

const selectVariation = (variation: ProductVariation) => {
    selectedVariation.value = variation;
};

const addToCart = () => {
    if (!selectedVariation.value) return;
    if (Object.keys(selectedVariation.value).length === 0) return;
    if (cartStore.isProductInCart(selectedVariation)) return;

    cartStore.increaseProductQuantity(selectedVariation.value);
};
</script>
