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
                class="relative flex flex-col overflow-hidden bg-gray-100 shadow-md rounded-xl"
            >
                <div class="p-4">
                    <u-button
                        :ui="{ rounded: 'rounded-full' }"
                        class="absolute flex items-center justify-center w-10 h-10 top-1 right-1"
                        :class="{
                            'bg-red-500': favoriteStore.isFavorite(product),
                            'bg-gray-300': !favoriteStore.isFavorite(product),
                        }"
                        color="red"
                        icon="heroicons-solid:heart"
                        @click="favoriteStore.toggleFavorite(product)"
                    />

                    <nuxt-link
                        :to="`/products/${product.category.slug}/${product.slug}`"
                        class="block p-3 mx-4 h-[220px] rounded-lg overflow-hidden cursor-pointer bg-transparent"
                    >
                        <nuxt-img
                            :src="product.product_images[0]"
                            :alt="product.name"
                            class="object-contain w-full h-full hover:scale-[1.03] ease-in-out transition-all rounded-lg"
                            placeholder="/placeholder.png"
                        />
                    </nuxt-link>
                </div>

                <div
                    class="flex flex-col justify-between gap-3 p-6 text-center h-1/2"
                >
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ product.name }}
                        </h3>

                        <p class="text-gray-600 text-md">
                            {{ product.description }}
                        </p>
                    </div>

                    <u-button
                        :to="`/products/${product.category.slug}/${product.slug}`"
                        block
                        size="lg"
                        color="orange"
                        class="font-semibold"
                        label="View"
                    />
                </div>
            </div>
        </div>

        <div class="flex justify-center w-full mt-6">
            <u-pagination
                v-if="withPagination && pageCount > 0"
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
