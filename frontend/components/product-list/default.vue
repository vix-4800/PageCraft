<template>
    <div
        class="font-[sans-serif] py-4 mx-auto lg:max-w-6xl max-w-lg md:max-w-full"
    >
        <h2 class="mb-6 text-4xl font-extrabold text-gray-800">Our Products</h2>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="product in products"
                :key="product.slug"
                class="relative flex flex-col overflow-hidden bg-gray-200 rounded-xl"
            >
                <div class="p-4">
                    <button
                        type="button"
                        class="absolute flex items-center justify-center w-10 h-10 transition-colors bg-gray-100 border rounded-full cursor-pointer top-1 right-1"
                        :class="{
                            'border-red-300 bg-red-100':
                                favoriteStore.isFavorite(product),
                        }"
                        @click="toggleFavorite(product)"
                    >
                        <u-icon
                            name="heroicons-solid:heart"
                            size="25"
                            class="text-black transition-all ease-in-out hover:scale-110"
                            :class="{
                                'text-red-500 hover:text-red-600':
                                    favoriteStore.isFavorite(product),
                            }"
                        />
                    </button>

                    <nuxt-link
                        :to="`/products/${product.slug}`"
                        class="block p-3 mx-4 h-[220px] rounded-lg overflow-hidden cursor-pointer bg-white"
                    >
                        <nuxt-img
                            :src="product.image"
                            :alt="product.name"
                            class="object-contain w-full h-full hover:scale-[1.03] ease-in-out transition-all rounded-lg"
                            placeholder="/placeholder.png"
                        />
                    </nuxt-link>
                </div>

                <div class="flex flex-col gap-3 p-6 text-center h-1/2">
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

const favoriteStore = useFavoriteStore();
const toggleFavorite = (product: Product) => {
    favoriteStore.toggleFavorite(product);
};
</script>
