import { defineStore } from 'pinia';
import type { Product } from '~/types/product';

export const useFavoriteStore = defineStore('favorite', {
    state: () => ({
        items: [] as string[],
    }),
    actions: {
        toggleFavorite(product: Product) {
            const index = this.items.findIndex((slug) => slug === product.slug);

            if (index !== -1) {
                this.items.splice(index, 1);

                useNuxtApp().$notify(
                    `${product.name} removed from favorites`,
                    'error'
                );
            } else {
                this.items.push(product.slug);

                useNuxtApp().$notify(
                    `${product.name} added to favorites`,
                    'success'
                );
            }
        },
        isFavorite(product: Product): boolean {
            return this.items.some((slug) => slug === product.slug);
        },
    },
    getters: {
        totalItemsCount(): number {
            return this.items.length;
        },
    },
    persist: true,
});
