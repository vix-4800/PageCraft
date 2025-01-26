<template>
    <div>
        <dashboard-page-name
            title="Marketplace Accounts"
            :subtitle="`#${account?.id}`"
            :description="`${account?.name} (${account?.marketplace})`"
        />
    </div>
</template>

<script lang="ts" setup>
import type { MarketplaceAccount } from '~/types/marketplace_account';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});

const route = useRoute();
const loading = ref(false);
const account = ref<MarketplaceAccount>();

onMounted(async () => {
    loading.value = true;

    const { data } = await apiFetch<{ data: MarketplaceAccount }>(
        `v1/marketplaces/accounts/${route.params.id}`
    );

    account.value = data;
    loading.value = false;
});
</script>
