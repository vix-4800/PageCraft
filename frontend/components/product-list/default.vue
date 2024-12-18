<template>
    <div
        class="font-[sans-serif] py-4 mx-auto lg:max-w-6xl max-w-lg md:max-w-full"
    >
        <h2 class="mb-6 text-4xl font-extrabold text-gray-800">{{ title }}</h2>

        <div
            class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
            v-if="loading"
        >
            <USkeleton class="h-96 rounded-xl" v-for="i in 3" />
        </div>

        <div
            class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
            v-else
        >
            <div
                v-for="product in products"
                :key="product.slug"
                class="relative flex flex-col overflow-hidden bg-gray-200 rounded-xl"
            >
                <div class="p-4">
                    <u-button
                        :ui="{ rounded: 'rounded-full' }"
                        class="absolute flex items-center justify-center w-10 h-10 top-1 right-1"
                        :class="{
                            'bg-red-500': favoriteStore.isFavorite(product),
                            'bg-gray-400': !favoriteStore.isFavorite(product),
                        }"
                        @click="toggleFavorite(product)"
                        color="red"
                        icon="heroicons-solid:heart"
                    />

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

                    <u-button
                        :to="`/products/${product.slug}`"
                        block
                        size="lg"
                        color="orange"
                        class="mt-auto font-semibold"
                        label="View"
                    />
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
    title: {
        type: String,
        required: true,
    },
    loading: {
        type: Boolean,
        default: false,
    },
});

const favoriteStore = useFavoriteStore();
const toggleFavorite = (product: Product) => {
    favoriteStore.toggleFavorite(product);
};
</script>
