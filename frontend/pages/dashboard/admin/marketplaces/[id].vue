<template>
    <div>
        <dashboard-page-name
            title="Marketplace Accounts"
            :subtitle="`#${account?.id}`"
            :description="`Created on ${account?.created_at || ''}`"
        />

        <u-form v-if="account" :state="account" class="space-y-4">
            <u-form-group label="Name" name="name">
                <u-input
                    v-model="account.name"
                    color="blue"
                    size="md"
                    placeholder="Name"
                />
            </u-form-group>

            <u-form-group
                v-for="setting in account.settings"
                :key="setting.key"
                name="value"
                :label="setting.key"
            >
                <u-input
                    v-model="setting.value"
                    color="blue"
                    size="md"
                    placeholder="Value"
                />
            </u-form-group>

            <u-button
                icon="material-symbols:save"
                type="submit"
                size="md"
                color="blue"
                label="Save"
                :loading="loading"
                @click="save"
            />
        </u-form>
    </div>
</template>

<script lang="ts" setup>
import type { MarketplaceAccount } from '~/types/marketplace_account';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const { $notify } = useNuxtApp();

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

const save = async () => {
    loading.value = true;

    await apiFetch(`v1/marketplaces/accounts/${route.params.id}`, {
        method: 'PUT',
        body: {
            name: account.value?.name,
            settings: account.value?.settings,
        },
    });

    $notify('Marketplace account updated successfully', 'success');
    loading.value = false;
};
</script>
