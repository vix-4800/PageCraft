import { defineStore } from 'pinia';
import type { ProductVariant } from '~/types/product_variant';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: useLocalStorage<{ product: ProductVariant; quantity: number }[]>(
            'cart',
            []
        ),
    }),
    actions: {
        increaseProductQuantity(product: ProductVariant) {
            const existingProduct = this.items.find(
                (p) => p.product.sku === product.sku
            );

            if (existingProduct) {
                existingProduct.quantity++;
            } else {
                this.items.push({ product, quantity: 1 });
            }
        },
        decreaseProductQuantity(product: ProductVariant) {
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
        removeProduct(product: ProductVariant) {
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
