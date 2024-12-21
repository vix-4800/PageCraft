<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Product '{{ product.name }}'</h2>
        </div>
        <div class="p-6">
            <u-form
                @submit="submitForm"
                class="flex flex-col min-w-full gap-6 space-y-4 overflow-x-auto rounded"
            >
                <div class="px-1 space-y-2">
                    <h3 class="text-xl font-bold text-gray-800">Details</h3>

                    <div class="flex w-full gap-2">
                        <u-form-group label="Name" class="w-1/2" name="name">
                            <u-input color="blue" v-model="product.name" />
                        </u-form-group>

                        <u-form-group label="Slug" class="w-1/2" name="slug">
                            <u-input color="blue" v-model="product.slug" />
                        </u-form-group>
                    </div>

                    <u-form-group label="Description" name="description">
                        <u-textarea
                            color="blue"
                            v-model="product.description"
                        />
                    </u-form-group>
                </div>

                <nuxt-img
                    :src="product.image"
                    :alt="product.name"
                    class="object-contain w-full h-96"
                />

                <div class="space-y-3">
                    <h3 class="text-xl font-bold text-gray-800">
                        Variations ({{ variations.length }})
                    </h3>

                    <div class="px-1 space-y-2">
                        <u-card
                            class="bg-slate-100"
                            v-for="variation in variations"
                            :key="variation.sku"
                        >
                            <template #header>
                                <h3 class="text-lg font-bold">
                                    Variation with sku '{{ variation.sku }}'
                                </h3>
                            </template>

                            <div class="space-y-3">
                                <div class="flex gap-2">
                                    <u-form-group label="Sku" class="w-1/3">
                                        <u-input
                                            color="blue"
                                            v-model="variation.sku"
                                            required
                                        />
                                    </u-form-group>

                                    <u-form-group label="Price" class="w-1/3">
                                        <u-input
                                            color="blue"
                                            v-model="variation.price"
                                            required
                                        />
                                    </u-form-group>

                                    <u-form-group
                                        label="Quantity"
                                        class="w-1/3"
                                    >
                                        <u-input
                                            color="blue"
                                            v-model="variation.stock"
                                            required
                                        />
                                    </u-form-group>
                                </div>

                                <u-form-group label="Image">
                                    <u-input
                                        color="blue"
                                        type="file"
                                        @change="
                                            handleFileChange($event, variation)
                                        "
                                        :ui="{
                                            icon: { trailing: { pointer: '' } },
                                        }"
                                    >
                                        <template #trailing>
                                            <u-button
                                                v-show="variation.image"
                                                color="gray"
                                                variant="link"
                                                icon="i-heroicons-x-mark-20-solid"
                                                :padded="false"
                                                @click="variation.image = null"
                                            />
                                        </template>
                                    </u-input>
                                </u-form-group>

                                <div class="flex flex-col gap-2">
                                    <h3 class="text-lg font-bold">
                                        Attributes ({{
                                            variation.attributes.length
                                        }})
                                    </h3>
                                    <div
                                        class="flex gap-2"
                                        v-for="attribute in variation.attributes"
                                        :key="attribute.name"
                                    >
                                        <u-form-group
                                            label="Name"
                                            class="w-1/2"
                                            name="attribute.name"
                                        >
                                            <u-input
                                                color="blue"
                                                v-model="attribute.name"
                                                required
                                            />
                                        </u-form-group>

                                        <u-form-group
                                            label="Value"
                                            class="w-1/2"
                                            name="attribute.value"
                                        >
                                            <u-input
                                                color="blue"
                                                v-model="attribute.value"
                                                required
                                            />
                                        </u-form-group>
                                    </div>

                                    <div class="flex gap-2">
                                        <u-button
                                            color="orange"
                                            size="md"
                                            label="Add Attribute"
                                            @click="addAttribute(variation)"
                                        />

                                        <u-button
                                            v-if="
                                                variation.attributes.length > 0
                                            "
                                            color="red"
                                            size="md"
                                            label="Remove Attribute"
                                            @click="removeAttribute(variation)"
                                        />
                                    </div>
                                </div>
                            </div>
                        </u-card>
                    </div>

                    <div class="flex gap-2">
                        <u-button
                            color="orange"
                            size="md"
                            label="Add Variation"
                            @click="addVariation"
                        />
                        <u-button
                            v-if="variations.length > 0"
                            color="red"
                            size="md"
                            label="Remove Variation"
                            @click="removeVariation"
                        />
                    </div>
                </div>

                <div class="flex gap-2">
                    <u-button
                        color="blue"
                        size="md"
                        label="Save"
                        type="submit"
                    />
                    <u-button
                        color="red"
                        @click="deleteProduct"
                        size="md"
                        label="Delete"
                    />
                </div>
            </u-form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product, ProductVariation } from '~/types/product';
definePageMeta({
    layout: 'dashboard',
    middleware: ['sanctum:auth'],
});

const apiUrl: string = useRuntimeConfig().public.apiUrl;
const route = useRoute();

const product = ref<Product>({});
const variations = ref<ProductVariation[]>([]);

const { $notify } = useNuxtApp();

onMounted(async () => {
    const { data } = await $fetch<{ data: Product }>(
        `${apiUrl}/v1/products/${route.params.slug}`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
        }
    );

    product.value = data;
    variations.value = data.variations ?? [];
});

const submitForm = async () => {
    await $fetch<{ data: Product }>(
        `${apiUrl}/v1/products/${route.params.slug}`,
        {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                Authorization: `Bearer ${useAuthStore().authToken}`,
            },
            body: product.value,
        }
    );
};

const deleteProduct = async () => {
    await $fetch(`${apiUrl}/v1/products/${route.params.slug}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${useAuthStore().authToken}`,
        },
    });

    navigateTo(`/dashboard/products`);
    $notify('Product created successfully', 'success');
};

function addVariation() {
    variations.value = [
        ...variations.value,
        {
            sku: undefined,
            price: undefined,
            stock: undefined,
            image: undefined,
            attributes: [],
        },
    ];
}

function removeVariation() {
    variations.value.pop();
}

function addAttribute(variation: ProductVariation) {
    variation.attributes.push({
        name: undefined,
        value: undefined,
    });
}

function removeAttribute(variation: ProductVariation) {
    variation.attributes.pop();
}

function handleFileChange(event: Event, variation: ProductVariation) {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files[0]) {
        variation.image = input.files[0];
    }
}
</script>
