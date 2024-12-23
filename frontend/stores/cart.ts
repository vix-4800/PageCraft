import { defineStore } from 'pinia';
import type { ProductVariation } from '~/types/product';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: [] as { sku: string; quantity: number }[],
    }),
    actions: {
        increaseProductQuantity(product: ProductVariation) {
            const existingProduct = this.items.find(
                (p) => p.sku === product.sku
            );

            if (existingProduct) {
                existingProduct.quantity++;
            } else {
                this.items.push({ sku: product.sku, quantity: 1 });

                useNuxtApp().$notify(`${product.sku} added to cart`, 'success');
            }
        },
        decreaseProductQuantity(product: ProductVariation) {
            const index = this.items.findIndex((p) => p.sku === product.sku);

            if (index !== -1) {
                const existingProduct = this.items[index];
                if (existingProduct.quantity > 1) {
                    existingProduct.quantity--;
                }
            }
        },
        removeProduct(product: ProductVariation) {
            const index = this.items.findIndex((p) => p.sku === product.sku);

            if (index !== -1) {
                this.items.splice(index, 1);

                useNuxtApp().$notify(
                    `${product.sku} removed from cart`,
                    'error'
                );
            }
        },
        clearCart() {
            this.items = [];
        },
        isProductInCart(product: ProductVariation): boolean {
            return this.items.some((p) => p.sku === product.sku);
        },
        getQuantity(product: ProductVariation): number {
            const item = this.items.find((p) => p.sku === product.sku);
            return item ? item.quantity : 0;
        },
    },
    getters: {
        totalItems(): number {
            return this.items.reduce((total, p) => total + p.quantity, 0);
        },
    },
    persist: true,
});
