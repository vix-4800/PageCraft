<template>
    <div>
        <dashboard-page-name
            title="Marketplace Accounts"
            :subtitle="accounts.length.toString()"
        />

        <u-table
            :columns="columns"
            :rows="accounts"
            :loading="loading"
            :loading-state="{
                icon: 'i-heroicons-arrow-path-20-solid',
                label: 'Loading...',
            }"
            :progress="{ color: 'blue', animation: 'carousel' }"
            class="w-full"
            :empty-state="{
                icon: 'material-symbols:info',
                label: 'No marketplace accounts',
            }"
            @select="select"
        />
    </div>
</template>

<script lang="ts" setup>
import type { MarketplaceAccount } from '~/types/marketplace_account';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

const columns = [
    {
        key: 'id',
        label: 'ID',
        sortable: true,
    },
    {
        key: 'name',
        label: 'Name',
        sortable: true,
    },
    {
        key: 'marketplace',
        label: 'Marketplace',
        sortable: true,
    },
    {
        key: 'created_at',
        label: 'Created At',
        sortable: true,
    },
];

const loading = ref(false);
const accounts = ref<MarketplaceAccount[]>([]);

onMounted(async () => {
    loading.value = true;

    const { data } = await apiFetch<{ data: MarketplaceAccount[] }>(
        'v1/marketplaces/accounts'
    );

    accounts.value = data;
    loading.value = false;
});

function select(row: MarketplaceAccount) {
    return navigateTo('/dashboard/admin/marketplaces/' + row.id);
}
</script>
