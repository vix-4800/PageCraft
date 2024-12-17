<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Products</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full overflow-x-auto rounded">
                <div class="w-full px-1">
                    <u-button
                        color="blue"
                        block
                        size="md"
                        type="button"
                        @click="navigateTo('/dashboard/products/create')"
                    >
                        Add Product
                    </u-button>
                </div>

                <hr class="my-4 border-gray-300" />

                <u-table
                    :columns="columns"
                    :rows="products"
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
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
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

const apiUrl: string = useRuntimeConfig().public.apiUrl;

const products = ref<Product[]>([]);
const status = ref('idle');
onMounted(async () => {
    await getProducts();
});

async function getProducts() {
    const response: { data: Product[] } = await $fetch<{ data: Product[] }>(
        `${apiUrl}/v1/products`,
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
    );

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
