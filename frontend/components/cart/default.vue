<template>
    <div class="grid gap-8 mt-16 md:grid-cols-3">
        <div v-auto-animate class="space-y-4 md:col-span-2">
            <div
                v-for="item in cartItems"
                :key="item.product.slug"
                class="grid items-start grid-cols-3 gap-4 pb-4 border-b border-gray-300"
            >
                <div class="flex items-start col-span-2 gap-4">
                    <div
                        class="p-2 bg-white border-2 border-gray-300 rounded-md w-28 h-28 max-sm:w-24 max-sm:h-24 shrink-0"
                    >
                        <nuxt-link
                            :to="`/products/${item.product.category.slug}/${item.product.slug}`"
                        >
                            <nuxt-img
                                :src="item.product.product_images[0]"
                                class="object-contain w-full h-full"
                            />
                        </nuxt-link>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <h3 class="text-base font-bold text-gray-800">
                            {{ item.product.name }}
                        </h3>
                        <div>
                            <span
                                v-for="attribute in item.attributes"
                                :key="attribute.name"
                                class="block text-xs font-semibold text-gray-500"
                            >
                                {{ capitalize(attribute.name) }}:
                                {{ capitalize(attribute.value) }}
                            </span>
                        </div>

                        <div>
                            <u-button
                                class="font-semibold"
                                label="REMOVE"
                                icon="material-symbols:delete-outline"
                                color="red"
                                @click="cartStore.removeProduct(item)"
                            />
                        </div>
                    </div>
                </div>

                <div class="ml-auto">
                    <h4
                        class="text-lg font-bold text-gray-800 max-sm:text-base"
                    >
                        ${{ item.price }}
                    </h4>

                    <div
                        class="flex items-center gap-2 mt-6 text-xs text-gray-800 bg-transparent border border-gray-300 rounded-md outline-none"
                    >
                        <u-button
                            size="xs"
                            class="bg-transparent text-slate-600 hover:text-slate-900 hover:bg-transparent"
                            icon="ic:baseline-minus"
                            @click="cartStore.decreaseProductQuantity(item)"
                        />

                        <span class="font-bold">
                            {{ cartStore.getQuantity(item.sku) }}
                        </span>

                        <u-button
                            size="xs"
                            class="bg-transparent text-slate-600 hover:text-slate-900 hover:bg-transparent"
                            icon="ic:baseline-plus"
                            @click="cartStore.increaseProductQuantity(item)"
                        />
                    </div>
                </div>
            </div>
        </div>

        <u-form
            :state="cartDetails"
            :schema="schema"
            class="p-4 bg-gray-100 rounded-md h-max"
            @submit="checkout"
        >
            <h3
                class="pb-2 text-lg font-bold text-gray-800 border-b border-gray-300 max-sm:text-base"
            >
                Order Summary
            </h3>

            <div class="mt-6">
                <div>
                    <h3 class="mb-4 text-base font-semibold text-gray-800">
                        Details
                    </h3>
                    <div class="space-y-3">
                        <div
                            v-if="!authStore.isAuthenticated"
                            class="space-y-3"
                        >
                            <u-form-group
                                size="lg"
                                name="name"
                                label="Name"
                                required
                            >
                                <u-input
                                    v-model="cartDetails.name"
                                    placeholder="Full Name"
                                    icon="material-symbols:person"
                                    trailing
                                    color="orange"
                                    size="lg"
                                    :disabled="cartStore.totalItems === 0"
                                />
                            </u-form-group>

                            <u-form-group
                                size="lg"
                                name="email"
                                label="Email"
                                required
                            >
                                <u-input
                                    v-model="cartDetails.email"
                                    placeholder="Email"
                                    type="email"
                                    icon="material-symbols:mail"
                                    trailing
                                    color="orange"
                                    size="lg"
                                    :disabled="cartStore.totalItems === 0"
                                />
                            </u-form-group>

                            <u-form-group
                                size="lg"
                                name="phone"
                                label="Phone"
                                required
                            >
                                <u-input
                                    v-model="cartDetails.phone"
                                    placeholder="Phone No."
                                    icon="material-symbols:phone-enabled"
                                    trailing
                                    color="orange"
                                    size="lg"
                                    :disabled="cartStore.totalItems === 0"
                                />
                            </u-form-group>
                        </div>

                        <u-form-group size="lg" name="note" label="Note">
                            <u-textarea
                                v-model="cartDetails.note"
                                autoresize
                                placeholder="Note"
                                icon="material-symbols:note-add"
                                trailing
                                color="orange"
                                size="lg"
                                :disabled="cartStore.totalItems === 0"
                            />
                        </u-form-group>
                    </div>
                </div>
            </div>

            <ul class="mt-6 space-y-3 text-gray-800">
                <li class="flex flex-wrap gap-4 text-sm">
                    Subtotal
                    <span class="ml-auto font-bold">
                        ${{ cartStore.cost.sub_total }}
                    </span>
                </li>

                <li class="flex flex-wrap gap-4 text-sm">
                    Shipping
                    <span class="ml-auto font-bold">
                        ${{ cartStore.cost.shipping }}
                    </span>
                </li>

                <li class="flex flex-wrap gap-4 text-sm">
                    Tax
                    <span class="ml-auto font-bold">
                        ${{ cartStore.cost.tax }}
                    </span>
                </li>

                <hr class="border-gray-300" />

                <li class="flex flex-wrap gap-4 text-sm font-bold">
                    Total
                    <span class="ml-auto">${{ cartStore.cost.total }}</span>
                </li>
            </ul>

            <div class="mt-6 space-y-3">
                <u-button
                    color="orange"
                    :disabled="cartStore.totalItems === 0"
                    class="justify-center font-semibold text-gray-800 disabled:opacity-75"
                    label="Checkout"
                    block
                    size="lg"
                    icon="material-symbols:shopping-cart"
                    type="submit"
                />

                <u-button
                    to="/products"
                    label="Continue Shopping"
                    icon="ic:round-keyboard-arrow-left"
                    variant="outline"
                    color="blue"
                    size="lg"
                    block
                    class="justify-center font-semibold text-gray-800"
                />
            </div>
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import type { ProductVariation } from '~/types/product';
import { z } from 'zod';

const cartStore = useCartStore();
const cartDetails = useCartDetailsStore();
const authStore = useAuthStore();

const cartItems = ref<ProductVariation[]>([]);
onMounted(async () => {
    cartItems.value = await cartStore.getVariations();
});

watch(
    () => cartStore.differentItems,
    async () => {
        cartItems.value = await cartStore.getVariations();
    }
);

const schema = z.object({
    name: z
        .string()
        .min(1, 'Name is required')
        .min(2, 'Must be at least 2 characters'),
    email: z.string().min(1, 'Email is required').email('Invalid email'),
    phone: z
        .string()
        .min(1, 'Phone is required')
        .min(8, 'Must be at least 8 characters'),
    note: z.string().nullable(),
});

const { $notify } = useNuxtApp();
const checkout = async () => {
    if (cartStore.totalItems === 0) {
        $notify('Please add some products to cart', 'warning');
        return;
    }

    await openPaymentWidget();
};
</script>
