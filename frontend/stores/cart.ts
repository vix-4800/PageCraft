import { defineStore } from 'pinia';
import type { ProductVariation } from '~/types/product';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: useLocalStorage<
            { product: ProductVariation; quantity: number }[]
        >('cart', []),
    }),
    actions: {
        increaseProductQuantity(product: ProductVariation) {
            const existingProduct = this.items.find(
                (p) => p.product.sku === product.sku
            );

            if (existingProduct) {
                existingProduct.quantity++;
            } else {
                this.items.push({ product, quantity: 1 });
            }
        },
        decreaseProductQuantity(product: ProductVariation) {
            const index = this.items.findIndex(
                (p) => p.product.sku === product.sku
            );

            if (index !== -1) {
                const existingProduct = this.items[index];
                if (existingProduct.quantity > 1) {
                    existingProduct.quantity--;
                }
            }
        },
        removeProduct(product: ProductVariation) {
            const index = this.items.findIndex(
                (p) => p.product.sku === product.sku
            );

            if (index !== -1) {
                this.items.splice(index, 1);
            }
        },
        clearCart() {
            this.items = [];
        },
        isProductInCart(product: ProductVariation): boolean {
            return (
                this.items.find((p) => p.product.sku === product.sku) !==
                undefined
            );
        },
    },
    getters: {
        totalItems(): number {
            return this.items.reduce((total, p) => total + p.quantity, 0);
        },
        totalPrice(): number {
            return this.items.reduce(
                (total, p) => total + p.product.price * p.quantity,
                0
            );
        },
    },
});
