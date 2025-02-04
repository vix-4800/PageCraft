<template>
    <div>
        <div
            v-if="loading"
            class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
        >
            <u-skeleton v-for="i in 3" :key="i" class="h-96 rounded-xl" />
        </div>

        <div
            v-else
            class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
        >
            <div
                v-for="product in products"
                :key="product.slug"
                class="w-full max-w-sm py-6 mx-auto mt-4 overflow-hidden bg-white rounded-lg shadow-xl"
            >
                <div class="flex items-center gap-2 px-6">
                    <h3 class="flex-1 text-xl font-bold text-gray-800">
                        {{ product.name }}
                    </h3>
                    <u-button
                        :ui="{ rounded: 'rounded-full' }"
                        :class="{
                            'bg-red-500 text-white hover:bg-red-600':
                                favoriteStore.isFavorite(product),
                            'bg-white': !favoriteStore.isFavorite(product),
                        }"
                        color="red"
                        variant="outline"
                        icon="heroicons-solid:heart"
                        @click="favoriteStore.toggleFavorite(product)"
                    />
                </div>

                <div>
                    <nuxt-img
                        :src="product.product_images[0]"
                        :alt="product.name"
                        class="w-full max-h-[275px] my-6"
                        placeholder="/placeholder.png"
                    />
                </div>

                <div class="flex flex-col justify-between px-6 min-h-[175px]">
                    <p class="text-sm leading-relaxed text-gray-600">
                        {{ product.description }}
                    </p>

                    <div class="flex flex-wrap items-center gap-4">
                        <h3 class="flex-1 text-xl font-bold text-gray-800">
                            ${{ product.price }}
                        </h3>
                        <u-button
                            :to="`/products/${product.category.slug}/${product.slug}`"
                            label="Order now"
                            class="px-5 py-2.5 rounded-lg text-white text-sm tracking-wider bg-blue-600 hover:bg-blue-700 outline-none"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center w-full mt-6">
            <u-pagination
                v-if="withPagination && pageCount > 1"
                v-model="page"
                size="lg"
                :active-button="{ variant: 'outline', color: 'orange' }"
                :inactive-button="{ color: 'gray' }"
                :page-count="pageCount"
                :total="products.length"
                :to="(page: number) => ({query: { page }})"
            />
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
    loading: {
        type: Boolean,
        default: false,
    },
    withPagination: {
        type: Boolean,
        default: false,
    },
    pageCount: {
        type: Number,
        default: 0,
    },
    currentPage: {
        type: Number,
        default: 1,
    },
});

const favoriteStore = useFavoriteStore();
const page = ref(1);
</script>
