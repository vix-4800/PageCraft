<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Product '{{ product.name }}'</h2>
        </div>
        <div class="p-6">
            <u-form
                class="flex flex-col min-w-full gap-6 space-y-4 overflow-x-auto rounded"
                @submit="submitForm"
            >
                <div class="px-1 space-y-2">
                    <h3 class="text-xl font-bold text-gray-800">Details</h3>

                    <div class="flex w-full gap-2">
                        <u-form-group label="Name" class="w-1/2" name="name">
                            <u-input v-model="product.name" color="blue" />
                        </u-form-group>

                        <u-form-group label="Slug" class="w-1/2" name="slug">
                            <u-input v-model="product.slug" color="blue" />
                        </u-form-group>
                    </div>

                    <u-form-group label="Description" name="description">
                        <u-textarea
                            v-model="product.description"
                            color="blue"
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
                            v-for="variation in variations"
                            :key="variation.sku"
                            class="bg-slate-100"
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
                                            v-model="variation.sku"
                                            color="blue"
                                            required
                                        />
                                    </u-form-group>

                                    <u-form-group label="Price" class="w-1/3">
                                        <u-input
                                            v-model="variation.price"
                                            color="blue"
                                            required
                                        />
                                    </u-form-group>

                                    <u-form-group
                                        label="Quantity"
                                        class="w-1/3"
                                    >
                                        <u-input
                                            v-model="variation.stock"
                                            color="blue"
                                            required
                                        />
                                    </u-form-group>
                                </div>

                                <u-form-group label="Image">
                                    <u-input
                                        color="blue"
                                        type="file"
                                        :ui="{
                                            icon: { trailing: { pointer: '' } },
                                        }"
                                        @change="
                                            handleFileChange($event, variation)
                                        "
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
                                        v-for="attribute in variation.attributes"
                                        :key="attribute.name"
                                        class="flex gap-2"
                                    >
                                        <u-form-group
                                            label="Name"
                                            class="w-1/2"
                                            name="attribute.name"
                                        >
                                            <u-input
                                                v-model="attribute.name"
                                                color="blue"
                                                required
                                            />
                                        </u-form-group>

                                        <u-form-group
                                            label="Value"
                                            class="w-1/2"
                                            name="attribute.value"
                                        >
                                            <u-input
                                                v-model="attribute.value"
                                                color="blue"
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
                        size="md"
                        label="Delete"
                        @click="deleteProduct"
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
    middleware: ['verified'],
});

const route = useRoute();

const product = ref<Product>({});
const variations = ref<ProductVariation[]>([]);

const { $notify } = useNuxtApp();

onMounted(async () => {
    const { data } = await apiFetch<{ data: Product }>(
        `v1/products/${route.params.slug}`
    );

    product.value = data;
    variations.value = data.variations ?? [];
});

const submitForm = async () => {
    await apiFetch<{ data: Product }>(`v1/products/${route.params.slug}`, {
        method: 'PUT',
        body: product.value,
    });
};

const deleteProduct = async () => {
    await apiFetch(`v1/products/${route.params.slug}`, {
        method: 'DELETE',
    });

    navigateTo(`/dashboard/admin/products`);
    $notify('Product created successfully', 'success');
};

function addVariation() {
    variations.value = [
        ...variations.value,
        {
            sku: '',
            price: 0,
            stock: 0,
            image: '',
            attributes: [],
        },
    ];
}

function removeVariation() {
    variations.value.pop();
}

function addAttribute(variation: ProductVariation) {
    variation.attributes.push({
        name: '',
        value: '',
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
