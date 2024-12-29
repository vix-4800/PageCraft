<template>
    <div>
        <DashboardPageName title="Products" />

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
                @click="navigateTo('/dashboard/admin/products/create')"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';

definePageMeta({
    layout: 'dashboard',
    middleware: ['verified'],
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
    const { data } = await apiFetch<{ data: Product[] }>(`v1/products`);

    status.value = 'success';
    products.value = data;
    products.value.forEach((product) => {
        product.description =
            product.description.length > 75
                ? `${product.description.slice(0, 75)}...`
                : product.description;
    });
}

function select(row: Product) {
    return navigateTo('/dashboard/admin/products/' + row.slug);
}
</script>
