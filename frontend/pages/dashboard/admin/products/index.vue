<template>
    <div>
        <dashboard-page-name title="Products">
            <template #actions>
                <u-button
                    label="Update Search Indexes"
                    icon="material-symbols:refresh"
                    color="blue"
                    size="md"
                    :loading="updatingIndexes"
                    @click="updateSearchIndexes"
                />

                <u-button
                    color="blue"
                    size="md"
                    icon="material-symbols:add"
                    label="Create Product"
                    @click="navigateTo('/dashboard/admin/products/create')"
                />

                <u-button
                    color="blue"
                    size="md"
                    icon="material-symbols:refresh"
                    label="Sync"
                    @click="navigateTo('/dashboard/admin/products/sync')"
                />
            </template>
        </dashboard-page-name>

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
            :empty-state="{
                icon: 'material-symbols-light:storefront-outline-rounded',
                label: 'No products',
            }"
            @select="select"
        />

        <div
            v-if="total > 10"
            class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
        >
            <u-pagination
                v-model="page"
                :active-button="{ variant: 'outline', color: 'blue' }"
                :inactive-button="{ color: 'gray' }"
                :total="total"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';
import type { Meta } from '~/types/pagination';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
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

const { $notify } = useNuxtApp();

const products = ref<Product[]>([]);
const status = ref('pending');

onMounted(async () => {
    await getProducts();
});

const page = ref(1);
const total = ref(0);

async function getProducts() {
    const { data, meta } = await apiFetch<{
        data: Product[];
        meta: Meta;
    }>(`v1/products`, {
        params: {
            page: page.value,
        },
    });

    status.value = 'success';
    products.value = data;
    products.value.forEach((product) => {
        product.description =
            product.description.length > 75
                ? `${product.description.slice(0, 75)}...`
                : product.description;
    });

    page.value = meta.current_page;
    total.value = meta.total;
}

watch(page, async () => {
    await getProducts();
});

function select(row: Product) {
    return navigateTo('/dashboard/admin/products/' + row.slug);
}

const updatingIndexes = ref(false);
async function updateSearchIndexes() {
    updatingIndexes.value = true;

    await apiFetch(`v1/products/update-search-indexes`, {
        method: 'POST',
    });

    updatingIndexes.value = false;
    $notify('Products Search Indexes Updated', 'success');
}
</script>
