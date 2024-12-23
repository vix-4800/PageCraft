<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Products</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full overflow-x-auto rounded">
                <u-table
                    :columns="columns"
                    :rows="products"
                    :loading="status === 'pending'"
                    :loading-state="{
                        icon: 'i-heroicons-arrow-path-20-solid',
                        label: 'Loading...',
                    }"
                    :progress="{ color: 'blue', animation: 'carousel' }"
                    class="w-full"
                    @select="select"
                />

                <div class="w-full px-1 mt-4">
                    <u-button
                        color="blue"
                        block
                        size="md"
                        :loading="status === 'pending'"
                        type="button"
                        label="Add Product"
                        @click="navigateTo('/dashboard/products/create')"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth'],
});

const columns = [
    {
        key: 'name',
        label: 'Name',
        sortable: true,
    },
    {
        key: 'slug',
        label: 'Slug',
    },
    {
        key: 'description',
        label: 'Description',
    },
];

const products = ref<Product[]>([]);
const status = ref('pending');
onMounted(async () => {
    await getProducts();
});

async function getProducts() {
    const response: { data: Product[] } = await apiFetch<{ data: Product[] }>(
        `v1/products`
    );

    status.value = 'success';

    products.value = response.data;
    products.value.forEach((product) => {
        product.description =
            product.description.length > 75
                ? `${product.description.slice(0, 75)}...`
                : product.description;
    });
}

function select(row: Product) {
    return navigateTo('/dashboard/products/' + row.slug);
}
</script>
