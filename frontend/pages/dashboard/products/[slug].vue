<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Product '{{ product.name }}'</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-col min-w-full gap-6 overflow-x-auto rounded">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Details</h3>

                    <ul>
                        <li>
                            <span class="font-semibold">Name:</span>
                            {{ product.name }}
                        </li>
                        <li>
                            <span class="font-semibold">Slug:</span>
                            {{ product.slug }}
                        </li>
                        <li>
                            <span class="font-semibold">Description:</span>
                            {{ product.description }}
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-800">Variations</h3>

                    <u-table
                        :columns="columns"
                        :rows="variations"
                        :loading="status === 'pending' || status === 'idle'"
                        :loading-state="{
                            icon: 'i-heroicons-arrow-path-20-solid',
                            label: 'Loading...',
                        }"
                        :progress="{ color: 'primary', animation: 'carousel' }"
                        class="w-full"
                        @select="select"
                    />
                </div>

                <div v-if="editFormVisible">
                    <h3 class="text-xl font-bold text-gray-800">
                        Edit Variation '{{ variantToEdit.sku }}'
                    </h3>

                    <ul>
                        <li>
                            <span class="font-semibold">Sku:</span>
                            {{ variantToEdit.sku }}
                        </li>
                        <li>
                            <span class="font-semibold">Price:</span>
                            {{ variantToEdit.price }}
                        </li>
                        <li>
                            <span class="font-semibold">Stock:</span>
                            {{ variantToEdit.stock }}
                        </li>
                        <li>
                            <span class="font-semibold">Attributes:</span>
                            <ul>
                                <li
                                    v-for="(
                                        attribute, key
                                    ) in variantToEdit.attributes"
                                    :key="key"
                                >
                                    {{ attribute.name }}:
                                    {{ attribute.value }}
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';
import type { ProductVariant } from '~/types/product_variant';

definePageMeta({
    layout: 'dashboard',
});

const apiUrl: string = useRuntimeConfig().public.apiUrl;

const product = ref<Product>({});
const variations = ref<ProductVariant[]>([]);

const status = ref('idle');

onMounted(async () => {
    const response: { data: Product } = await $fetch<{ data: Product[] }>(
        `${apiUrl}/v1/products/${useRoute().params.slug}`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            onRequest() {
                status.value = 'pending';
            },
            onResponse() {
                status.value = 'success';
            },
        }
    ).catch((error) => error.data);

    product.value = response.data;
    variations.value = product.value.variations;
});

const editFormVisible = ref(false);
const variantToEdit = ref<ProductVariant>();
function select(row: ProductVariant) {
    editFormVisible.value = true;
    variantToEdit.value = row;
}
</script>
