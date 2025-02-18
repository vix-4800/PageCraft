<template>
    <div>
        <dashboard-page-name title="Create Marketplace Account" />

        <u-form :state="account" class="space-y-4">
            <u-form-group label="Name" name="name">
                <u-input
                    v-model="account.name"
                    color="blue"
                    size="md"
                    placeholder="Name"
                />
            </u-form-group>

            <u-form-group label="Marketplace" name="marketplace">
                <u-select-menu
                    v-model="account.marketplace"
                    color="blue"
                    :options="marketplaceOptions"
                    size="md"
                    placeholder="Account Marketplace"
                    value-attribute="value"
                />
            </u-form-group>

            <div v-if="account.marketplace" v-auto-animate class="space-y-4">
                <div
                    v-for="setting in marketplaceSettings[account.marketplace]"
                    :key="setting.key"
                >
                    <u-form-group name="key" :label="setting.label">
                        <u-input
                            v-model="setting.value"
                            color="blue"
                            size="md"
                            :placeholder="setting.label"
                        />
                    </u-form-group>
                </div>
            </div>

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
import type { MarketplaceAccountSetting } from '~/types/marketplace_account';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const { $notify } = useNuxtApp();

const loading = ref(false);
const account = reactive({
    name: '',
    marketplace: '',
});

const marketplaceOptions = [
    { value: 'wildberries', label: 'Wildberries' },
    { value: 'ozon', label: 'Ozon' },
    { value: 'yandex', label: 'Yandex Market' },
];

const marketplaceSettings = {
    wildberries: [{ key: 'token', label: 'Token', value: '' }],
    ozon: [
        { key: 'client_id', label: 'Client ID', value: '' },
        { key: 'api_key', label: 'API Key', value: '' },
    ],
    yandex: [{ key: 'api_key', label: 'API Key', value: '' }],
};

const save = async () => {
    loading.value = true;

    account.settings = Object.values(marketplaceSettings[account.marketplace]);

    await apiFetch(`v1/marketplaces/accounts`, {
        method: 'POST',
        body: account,
    });

    navigateTo('/dashboard/admin/marketplaces');
    $notify('Marketplace account created successfully', 'success');
    loading.value = false;
};
</script>
