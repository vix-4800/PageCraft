<template>
    <div v-if="product">
        <div class="grid items-start grid-cols-1 gap-12 lg:grid-cols-5">
            <div
                class="top-0 w-full p-6 bg-gray-100 border border-orange-300 rounded-lg lg:col-span-3 lg:sticky"
            >
                <div
                    class="flex items-center justify-center p-2 bg-transparent rounded-xl"
                >
                    <u-carousel
                        ref="carouselRef"
                        v-slot="{ item }"
                        class="overflow-hidden rounded-lg"
                        :items="[product.product_images[0]]"
                        :ui="{ item: 'basis-full' }"
                    >
                        <nuxt-img
                            :src="item"
                            :alt="product.name"
                            class="w-full"
                            draggable="false"
                        />
                    </u-carousel>
                </div>
            </div>

            <div class="lg:col-span-2">
                <u-breadcrumb
                    :ui="{ active: 'text-orange-500' }"
                    :links="breadcrumbLinks"
                    divider="/"
                    class="mb-4"
                />

                <h2 class="text-2xl font-bold text-gray-800">
                    {{ product.name }}
                </h2>

                <div class="flex mt-2">
                    <u-icon
                        v-for="i in Math.round(product.reviews.average)"
                        :key="i"
                        name="line-md:star-alt-filled"
                        size="30"
                        class="bg-orange-400"
                    />

                    <u-icon
                        v-for="i in 5 - Math.round(product.reviews.average)"
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
                    <ul class="mt-2 space-y-3 text-sm text-gray-800 list-disc">
                        {{
                            product.description
                        }}
                    </ul>
                </div>

                <div
                    v-if="selectedVariation !== null"
                    class="flex flex-col gap-4 mt-6"
                >
                    <h3 class="text-xl font-bold text-gray-800">
                        Product Variations
                    </h3>

                    <div class="flex flex-wrap justify-center mx-auto gap-x-4">
                        <u-chip
                            v-for="variation in variations"
                            :key="variation.sku"
                            :text="variation.stock"
                            size="2xl"
                            :color="variation.stock === 0 ? 'red' : 'orange'"
                        >
                            <u-button
                                type="button"
                                class="p-2 bg-transparent border-2 border-gray-200 rounded-lg hover:bg-transparent disabled:bg-gray-300"
                                :class="
                                    variation.sku === selectedVariation.sku
                                        ? 'border-orange-400'
                                        : ''
                                "
                                :disabled="variation.stock === 0"
                                @click="selectVariation(variation)"
                            >
                                <nuxt-img
                                    :src="variation.image"
                                    alt="Product1"
                                    class="w-12 h-12 rounded-lg"
                                    width="48px"
                                    height="48px"
                                    placeholder="/placeholder.png"
                                />
                            </u-button>
                        </u-chip>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            Product Specifications
                        </h3>
                        <ul
                            class="mt-2 ml-4 space-y-2 text-sm text-gray-800 list-disc"
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
                                <u-kbd
                                    :value="
                                        attribute.value
                                            .charAt(0)
                                            .toUpperCase() +
                                        attribute.value.slice(1)
                                    "
                                    size="md"
                                />
                            </li>
                        </ul>
                    </div>

                    <div class="flex gap-4">
                        <u-button
                            v-if="!cartStore.isProductInCart(selectedVariation)"
                            color="orange"
                            icon="material-symbols:add-shopping-cart-sharp"
                            class="font-semibold"
                            label="Add to cart"
                            size="lg"
                            :disabled="
                                selectedVariation === null ||
                                selectedVariation.stock === 0
                            "
                            @click="addToCart"
                        />
                        <u-button
                            v-else
                            to="/cart"
                            color="cyan"
                            size="lg"
                            icon="material-symbols:shopping-cart"
                            class="font-semibold"
                            label="Go to cart"
                        />

                        <u-button
                            :color="
                                favoriteStore.isFavorite(product)
                                    ? 'red'
                                    : 'gray'
                            "
                            icon="material-symbols:favorite"
                            class="font-semibold"
                            size="lg"
                            :label="
                                favoriteStore.isFavorite(product)
                                    ? 'Remove from favorites'
                                    : 'Add to favorites'
                            "
                            @click="favoriteStore.toggleFavorite(product)"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <div class="flex justify-between w-1/2">
                <h3 class="text-xl font-bold text-gray-800">
                    Reviews ({{ product.reviews.count }})
                </h3>

                <u-button
                    v-if="authStore.isAuthenticated"
                    color="orange"
                    label="Write a review"
                    size="md"
                    icon="material-symbols:edit"
                    @click="reviewModalOpen = true"
                />
            </div>

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
                            product.reviews.count > 0
                                ? (product.reviews.stars.five_stars /
                                      product.reviews.count) *
                                  100
                                : 0
                        "
                        color="orange"
                    />
                    <p class="text-sm font-bold text-gray-800">
                        {{ product.reviews.stars.five_stars }}
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
                            product.reviews.count > 0
                                ? (product.reviews.stars.four_stars /
                                      product.reviews.count) *
                                  100
                                : 0
                        "
                        color="orange"
                    />
                    <p class="text-sm font-bold text-gray-800">
                        {{ product.reviews.stars.four_stars }}
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
                            product.reviews.count > 0
                                ? (product.reviews.stars.three_stars /
                                      product.reviews.count) *
                                  100
                                : 0
                        "
                        color="orange"
                    />
                    <p class="text-sm font-bold text-gray-800">
                        {{ product.reviews.stars.three_stars }}
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
                            product.reviews.count > 0
                                ? (product.reviews.stars.two_stars /
                                      product.reviews.count) *
                                  100
                                : 0
                        "
                        color="orange"
                    />
                    <p class="text-sm font-bold text-gray-800">
                        {{ product.reviews.stars.two_stars }}
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
                            product.reviews.count > 0
                                ? (product.reviews.stars.one_star /
                                      product.reviews.count) *
                                  100
                                : 0
                        "
                        color="orange"
                    />
                    <p class="text-sm font-bold text-gray-800">
                        {{ product.reviews.stars.one_star }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col items-start gap-8 mt-8">
                <div v-for="review in reviews" :key="review.id" class="flex">
                    <nuxt-img
                        :src="review.user?.avatar || '/placeholder.png'"
                        class="w-12 h-12 border-2 border-gray-300 rounded-full"
                        loading="lazy"
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
                                {{
                                    new Date(review.created_at).toLocaleString()
                                }}
                            </p>
                        </div>

                        <p class="mt-2 text-xs">
                            {{ review.text }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <u-modal v-if="authStore.isAuthenticated" v-model="reviewModalOpen">
            <div class="p-4">
                <h3 class="mb-4 text-lg font-bold text-gray-800 sm:text-xl">
                    Add Review
                </h3>

                <u-form
                    class="space-y-2"
                    :state="reviewForm"
                    :schema="schema"
                    @submit="submitReview"
                >
                    <u-form-group label="Text" name="text">
                        <u-textarea
                            v-model="reviewForm.text"
                            color="orange"
                            placeholder="Write your review here..."
                            autoresize
                        />
                    </u-form-group>

                    <u-form-group
                        :label="'Rating' + ' (' + reviewForm.rating + ')'"
                        name="rating"
                    >
                        <u-range
                            v-model="reviewForm.rating"
                            color="orange"
                            :min="1"
                            :max="5"
                        />
                    </u-form-group>

                    <div class="flex mt-4">
                        <u-button
                            icon="material-symbols:send"
                            type="submit"
                            color="orange"
                            :loading="reviewSending"
                            :disabled="reviewSending"
                        >
                            Submit
                        </u-button>
                    </div>
                </u-form>
            </div>
        </u-modal>
    </div>
</template>

<script lang="ts" setup>
import type { Product, ProductVariation } from '~/types/product';
import type { Review } from '~/types/review';
import { z } from 'zod';
import type { FormSubmitEvent } from '#ui/types';

const authStore = useAuthStore();
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

const carouselRef = ref();

const selectedVariation = ref<ProductVariation | null>(null);
onMounted(async () => {
    setInterval(() => {
        if (!carouselRef.value) return;

        if (carouselRef.value.page === carouselRef.value.pages)
            return carouselRef.value.select(0);

        carouselRef.value.next();
    }, 3000);
});

watch(
    () => props.variations,
    (newVariations) => {
        if (newVariations.length > 0 && !selectedVariation.value) {
            selectedVariation.value = newVariations[0];
        }
    },
    { immediate: true }
);

const breadcrumbLinks = computed(() => {
    return [
        {
            label: 'Home',
            icon: 'material-symbols:home',
            to: '/',
        },
        {
            label: 'Products',
            icon: 'material-symbols:storefront',
            to: '/products',
        },
        {
            label: props.product.category.name,
            icon: 'material-symbols:collections-bookmark',
            to: `/products/${props.product.category.slug}`,
        },
        {
            label: props.product.name,
            icon: 'material-symbols:arrow-forward',
        },
    ];
});

function selectVariation(variation: ProductVariation) {
    selectedVariation.value = variation;
}

const addToCart = () => {
    if (!selectedVariation.value) return;

    if (Object.keys(selectedVariation.value).length === 0) return;

    cartStore.increaseProductQuantity(selectedVariation.value);
};

const reviewModalOpen = ref(false);
const reviewForm = reactive({
    text: '',
    rating: 3,
});

const schema = z.object({
    text: z.string().min(5, 'Review text must be at least 5 characters'),
    rating: z
        .number()
        .min(1, 'Minimum rating is 1')
        .max(5, 'Maximum rating is 5'),
});

type Schema = z.output<typeof schema>;

const { $notify } = useNuxtApp();
const reviewSending = ref(false);
const submitReview = async (event: FormSubmitEvent<Schema>) => {
    reviewSending.value = true;

    await apiFetch(`v1/products/${props.product.slug}/reviews`, {
        method: 'POST',
        body: {
            text: event.data.text,
            rating: event.data.rating,
        },
    });

    reviewModalOpen.value = false;
    reviewSending.value = false;

    $notify('Review submitted successfully', 'success');
};
</script>
