<template>
    <div>
        <dashboard-page-name title="Sync Products" />

        <u-table
            v-model:row-selection="rowSelection"
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
        />
    </div>
</template>

<script lang="ts" setup>
// import { h, resolveComponent } from 'vue';
// import type { TableColumn, TableRow } from '@nuxt/ui';

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
];

const products = ref([
    { name: 'test 1' },
    { name: 'test 2' },
    { name: 'test 3' },
    { name: 'test 4' },
]);
const status = ref('pending');

const rowSelection = ref<Record<string, boolean>>({});

// function onSelect(row: TableRow<Payment>, e?: Event) {
//     /* If you decide to also select the column you can do this  */
//     row.toggleSelected(!row.getIsSelected());

//     console.log(e);
// }
</script>
