<template>
    <div>
        <div class="p-4 mx-auto font-sans lg:max-w-6xl md:max-w-4xl">
            <div
                class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 sm:gap-6"
            >
                <div
                    v-for="product in products"
                    :key="product.slug"
                    class="bg-white flex flex-col rounded-sm overflow-hidden shadow-md hover:scale-[1.01] transition-all"
                >
                    <div class="w-full">
                        <img
                            :src="product.product_images[0]"
                            :alt="product.name"
                            class="w-full object-cover object-top aspect-230/307"
                            placeholder="/placeholder.png"
                        />
                    </div>

                    <div class="flex flex-col flex-1 p-4">
                        <div class="flex-1">
                            <h5
                                class="text-sm font-bold text-gray-800 sm:text-base line-clamp-2"
                            >
                                {{ product.name }}
                            </h5>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <h6
                                    class="text-sm font-bold text-gray-800 sm:text-base"
                                >
                                    ${{ product.price }}
                                </h6>
                                <u-button
                                    class="flex items-center justify-center w-8 h-8 ml-auto bg-gray-100 rounded-full cursor-pointer"
                                    title="Wishlist"
                                    icon="material-symbols:favorite"
                                    :class="{
                                        'bg-red-400 hover:bg-red-500':
                                            favoriteStore.isFavorite(product),
                                        'bg-gray-200 hover:bg-gray-300':
                                            !favoriteStore.isFavorite(product),
                                    }"
                                    @click="
                                        favoriteStore.toggleFavorite(product)
                                    "
                                />
                            </div>
                        </div>
                        <u-button
                            :to="`/products/${product.category.slug}/${product.slug}`"
                            label="Add to Cart"
                            block
                            class="mt-4 font-semibold"
                            size="md"
                            color="blue"
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
                :active-button="{ variant: 'outline-solid', color: 'orange' }"
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
