<template>
    <div class="grid gap-4 font-sans md:grid-cols-3">
        <div class="p-4 bg-gray-100 rounded-md md:col-span-2">
            <div v-auto-animate class="space-y-4">
                <div
                    v-for="item in cartItems"
                    :key="item.product.slug"
                    class="grid items-center grid-cols-3 gap-4"
                >
                    <div class="flex items-center col-span-2 gap-4">
                        <div class="w-32 h-32 p-2 bg-white rounded-md shrink-0">
                            <nuxt-link :to="`/products/${item.product.slug}`">
                                <img
                                    :src="item.product.product_images[0]"
                                    class="object-contain w-full h-full"
                                />
                            </nuxt-link>
                        </div>

                        <div class="flex flex-col gap-2">
                            <h3 class="text-base font-bold text-gray-800">
                                {{ item.product.name }}
                            </h3>
                            <u-button
                                variant="link"
                                :padded="false"
                                color="red"
                                class="text-xs w-max"
                                @click="cartStore.removeProduct(item)"
                            >
                                Remove
                            </u-button>

                            <div class="relative flex gap-2">
                                <div
                                    v-for="attribute in item.attributes"
                                    :key="attribute.name"
                                    class="flex items-center px-2.5 py-1.5 border border-gray-300 text-gray-800 text-xs outline-hidden bg-transparent rounded-md"
                                >
                                    {{ capitalize(attribute.name) }}:
                                    {{ capitalize(attribute.value) }}
                                </div>
                            </div>

                            <div
                                class="flex items-center text-xs text-gray-800 bg-transparent border border-gray-300 rounded-md outline-hidden w-max"
                            >
                                <u-button
                                    size="xs"
                                    class="bg-transparent text-slate-600 hover:text-slate-900 hover:bg-transparent"
                                    icon="ic:baseline-minus"
                                    @click="
                                        cartStore.decreaseProductQuantity(item)
                                    "
                                />

                                <span class="mx-2.5">
                                    {{ cartStore.getQuantity(item.sku) }}
                                </span>

                                <u-button
                                    size="xs"
                                    class="bg-transparent text-slate-600 hover:text-slate-900 hover:bg-transparent"
                                    icon="ic:baseline-plus"
                                    @click="
                                        cartStore.increaseProductQuantity(item)
                                    "
                                />
                            </div>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <h4 class="text-base font-bold text-gray-800">
                            ${{ item.price }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <u-form
            :state="cartDetails"
            :schema="schema"
            class="top-0 p-4 bg-gray-100 rounded-md md:sticky h-min"
            @submit="checkout"
        >
            <div class="space-y-4">
                <div v-if="!authStore.isAuthenticated" class="space-y-3">
                    <u-form-field size="lg" name="name" label="Name" required>
                        <u-input
                            v-model="cartDetails.name"
                            placeholder="Full Name"
                            icon="material-symbols:person"
                            trailing
                            color="blue"
                            size="lg"
                            :disabled="cartStore.totalItems === 0"
                        />
                    </u-form-field>

                    <u-form-field size="lg" name="email" label="Email" required>
                        <u-input
                            v-model="cartDetails.email"
                            placeholder="Email"
                            type="email"
                            icon="material-symbols:mail"
                            trailing
                            color="blue"
                            size="lg"
                            :disabled="cartStore.totalItems === 0"
                        />
                    </u-form-field>

                    <u-form-field size="lg" name="phone" label="Phone" required>
                        <u-input
                            v-model="cartDetails.phone"
                            placeholder="Phone No."
                            icon="material-symbols:phone-enabled"
                            trailing
                            color="blue"
                            size="lg"
                            :disabled="cartStore.totalItems === 0"
                        />
                    </u-form-field>
                </div>

                <u-form-field size="lg" name="note" label="Note">
                    <u-textarea
                        v-model="cartDetails.note"
                        autoresize
                        placeholder="Note"
                        icon="material-symbols:note-add"
                        trailing
                        color="blue"
                        size="lg"
                        :disabled="cartStore.totalItems === 0"
                    />
                </u-form-field>
            </div>

            <ul class="mt-8 space-y-4 text-gray-800">
                <li class="flex flex-wrap gap-4 text-base">
                    Subtotal
                    <span class="ml-auto font-bold">
                        ${{ cartStore.cost.sub_total }}
                    </span>
                </li>
                <li class="flex flex-wrap gap-4 text-base">
                    Shipping
                    <span class="ml-auto font-bold">
                        ${{ cartStore.cost.shipping }}
                    </span>
                </li>
                <li class="flex flex-wrap gap-4 text-base">
                    Tax
                    <span class="ml-auto font-bold">
                        ${{ cartStore.cost.tax }}
                    </span>
                </li>
                <li class="flex flex-wrap gap-4 text-base font-bold">
                    Total
                    <span class="ml-auto">${{ cartStore.cost.total }}</span>
                </li>
            </ul>

            <div class="mt-8 space-y-2">
                <u-button
                    block
                    type="submit"
                    :disabled="cartStore.totalItems === 0"
                    label="Checkout"
                    color="blue"
                    size="lg"
                    class="font-semibold"
                />

                <u-button
                    to="/products"
                    block
                    label="Continue Shopping"
                    size="lg"
                    color="white"
                    class="font-semibold"
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
