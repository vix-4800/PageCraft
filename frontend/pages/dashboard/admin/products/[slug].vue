<template>
    <div v-if="product">
        <dashboard-page-name title="Product" :subtitle="product.name" />

        <u-form
            :state="product"
            class="flex flex-col min-w-full gap-6 space-y-4 overflow-x-auto rounded"
            @submit="save"
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
                    <u-textarea v-model="product.description" color="blue" />
                </u-form-group>
            </div>

            <div class="grid grid-cols-2 grid-rows-3 gap-4">
                <nuxt-img
                    v-for="(image, index) in product.product_images"
                    :key="index"
                    :src="product.product_images[index]"
                    :alt="product.name"
                    class="object-contain w-full"
                    :class="{
                        'col-span-2 max-h-64':
                            index === product.product_images.length - 1,
                    }"
                />
            </div>

            <div class="space-y-3">
                <h3 class="text-xl font-bold text-gray-800">
                    Variations ({{ variations.length }})
                </h3>

                <div class="px-1 space-y-2">
                    <u-card
                        v-for="(variation, index) in variations"
                        :key="variation.sku"
                        class="bg-slate-100"
                    >
                        <template #header>
                            <div class="flex justify-between">
                                <h3 class="text-lg font-bold">
                                    Variation with sku '{{ variation.sku }}'
                                </h3>

                                <u-button
                                    color="blue"
                                    variant="link"
                                    size="sm"
                                    :icon="
                                        index === currentShownVariation
                                            ? 'i-heroicons-chevron-up'
                                            : 'i-heroicons-chevron-down'
                                    "
                                    @click="toggleVariation(index)"
                                />
                            </div>
                        </template>

                        <div
                            v-show="index === currentShownVariation"
                            class="space-y-3"
                        >
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

                                <u-form-group label="Quantity" class="w-1/3">
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
                                        icon="material-symbols:add"
                                        @click="addAttribute(variation)"
                                    />

                                    <u-button
                                        v-if="variation.attributes.length > 0"
                                        color="red"
                                        size="md"
                                        icon="material-symbols:remove"
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
                        icon="material-symbols:add"
                        label="Add Variation"
                        @click="addVariation"
                    />
                    <u-button
                        v-if="variations.length > 0"
                        color="red"
                        size="md"
                        icon="material-symbols:remove"
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
                    icon="material-symbols:save"
                    type="submit"
                />
                <u-button
                    color="red"
                    size="md"
                    icon="material-symbols:delete"
                    label="Delete"
                    @click="deleteProduct"
                />
            </div>
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import type { Product, ProductVariation } from '~/types/product';
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const route = useRoute();

const product = ref<Product>();
const variations = ref<ProductVariation[]>([]);
const currentShownVariation = ref(-1);

const toggleVariation = (index: number) => {
    if (index === currentShownVariation.value) {
        currentShownVariation.value = -1;
    } else {
        currentShownVariation.value = index;
    }
};

const { $notify } = useNuxtApp();

onMounted(async () => {
    const { data } = await apiFetch<{ data: Product }>(
        `v1/products/${route.params.slug}`
    );

    product.value = data;
    variations.value = data.variations ?? [];
});

const save = async () => {
    const formData = new FormData();
    formData.append('name', product.value.name);
    formData.append('slug', product.value.slug);
    formData.append('description', product.value.description);

    if (product.value.product_images.length > 0) {
        product.value.product_images.forEach((image, index) => {
            formData.append(`product_images[${index}]`, image);
        });
    }

    product.value.variations.forEach((variation, index) => {
        formData.append(`variations[${index}][sku]`, variation.sku);
        formData.append(`variations[${index}][price]`, variation.price);
        formData.append(`variations[${index}][stock]`, variation.stock);

        variation.attributes.forEach((attribute, attrIndex) => {
            formData.append(
                `variations[${index}][attributes][${attrIndex}][name]`,
                attribute.name
            );
            formData.append(
                `variations[${index}][attributes][${attrIndex}][value]`,
                attribute.value
            );
        });
    });

    await apiFetch<{ data: Product }>(`v1/products/${route.params.slug}`, {
        method: 'PUT',
        body: formData,
    });
};

const deleteProduct = async () => {
    withPasswordConfirmation(
        async () => {
            await apiFetch(`v1/products/${route.params.slug}`, {
                method: 'DELETE',
            });

            navigateTo(`/dashboard/admin/products`);
            $notify('Product deleted successfully', 'success');
        },
        'Confirm product deletion',
        'Are you sure you want to delete this product?',
        true
    );
};

function addVariation() {
    variations.value = [
        ...variations.value,
        {
            sku: '',
            price: 0,
            stock: 0,
            image: null,
            attributes: [],
        },
    ];

    toggleVariation(variations.value.length - 1);
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
