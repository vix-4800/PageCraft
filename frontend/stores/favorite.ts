import { defineStore } from 'pinia';
import type { Product } from '~/types/product';

export const useFavoriteStore = defineStore('favorite', {
    state: () => ({
        items: useLocalStorage<Product[]>('favorites', []),
    }),
    actions: {
        toggleFavorite(product: Product) {
            const index = this.items.findIndex((p) => p.slug === product.slug);

            if (index !== -1) {
                this.items.splice(index, 1);
            } else {
                this.items.push(product);
            }
        },
        isFavorite(product: Product): boolean {
            return this.items.some((p) => p.slug === product.slug);
        },
    },
    getters: {
        totalItemsCount(): number {
            return this.items.length;
        },
    },
});
