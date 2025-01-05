import { defineStore } from 'pinia';
import type { ProductVariation } from '~/types/product';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: [] as {
            sku: string;
            price: number;
            quantity: number;
        }[],
        cost: {
            sub_total: 0 as number,
            shipping: 0 as number,
            tax: 0 as number,
            total: 0 as number,
        },
        details: {
            name: useAuthStore().isAuthenticated
                ? useAuthStore().user?.name
                : ('' as string),
            email: useAuthStore().isAuthenticated
                ? useAuthStore().user?.email
                : '',
            phone: useAuthStore().isAuthenticated
                ? useAuthStore().user?.phone
                : '',
            note: '' as string,
        },
    }),
    actions: {
        increaseProductQuantity(product: ProductVariation) {
            if (this.isProductInCart(product)) {
                this.items = this.items.map((p) => {
                    if (p.sku === product.sku) {
                        p.quantity++;
                    }
                    return p;
                });
            } else {
                this.items.push({
                    sku: product.sku,
                    price: product.price,
                    quantity: 1,
                });

                useNuxtApp().$notify(`${product.sku} added to cart`, 'success');
            }

            this.calculateCosts();
        },
        decreaseProductQuantity(product: ProductVariation) {
            if (this.isProductInCart(product)) {
                const index = this.items.findIndex(
                    (p) => p.sku === product.sku
                );
                const existingProduct = this.items[index];

                if (existingProduct.quantity > 1) {
                    existingProduct.quantity--;
                }

                this.calculateCosts();
            }
        },
        removeProduct(product: ProductVariation) {
            if (this.isProductInCart(product)) {
                const index = this.items.findIndex(
                    (p) => p.sku === product.sku
                );
                this.items.splice(index, 1);

                useNuxtApp().$notify(
                    `${product.sku} removed from cart`,
                    'error'
                );

                this.calculateCosts();
            }
        },
        calculateCosts() {
            this.cost.sub_total = this.items.reduce(
                (acc, item) => acc + item.price * this.getQuantity(item.sku),
                0
            );

            this.cost.shipping =
                Math.round(0.05 * this.cost.sub_total * 100) / 100;

            this.cost.tax = Math.round(0.1 * this.cost.sub_total * 100) / 100;

            this.cost.total =
                Math.round(
                    (this.cost.sub_total + this.cost.shipping + this.cost.tax) *
                        100
                ) / 100;
        },
        clearCart() {
            this.items = [];
            this.details = {
                name: '',
                email: '',
                phone: '',
                note: '',
            };

            this.calculateCosts();
        },
        isProductInCart(product: ProductVariation): boolean {
            return this.items.some((p) => p.sku === product.sku);
        },
        getQuantity(productSku: string): number {
            const item = this.items.find((p) => p.sku === productSku);

            return item ? item.quantity : 0;
        },
        async getVariations(): Promise<ProductVariation[]> {
            if (this.totalItems > 0) {
                const skus = this.items.map((item) => item.sku);

                const { data } = await apiFetch<{ data: ProductVariation[] }>(
                    `v1/variations`,
                    {
                        params: {
                            skus: skus.join(','),
                        },
                    }
                );

                return data;
            }

            return [];
        },
        async createOrder() {
            await apiFetch(`v1/orders`, {
                method: 'POST',
                body: {
                    products: this.items.map((item) => ({
                        sku: item.sku,
                        quantity: this.getQuantity(item.sku),
                    })),
                    tax: this.cost.tax,
                    shipping: this.cost.shipping,
                    note: this.details.note,
                    details: {
                        name: this.details.name,
                        email: this.details.email,
                        phone: this.details.phone,
                    },
                },
            });
        },
    },
    getters: {
        totalItems(): number {
            return this.items.reduce((total, p) => total + p.quantity, 0);
        },
        differentItems(): number {
            return this.items.length;
        },
    },
    persist: true,
});
