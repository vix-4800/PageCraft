<template>
    <div>
        <dashboard-page-name title="Marketplace Accounts" />

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
                    size="lg"
                    placeholder="Account Marketplace"
                    value-attribute="value"
                />
            </u-form-group>

            <div v-auto-animate class="space-y-4">
                <div
                    v-for="(setting, index) in account.settings"
                    :key="setting.key"
                    class="flex gap-4"
                >
                    <u-form-group name="key" label="Key" class="w-1/2">
                        <u-input
                            v-model="setting.key"
                            color="blue"
                            size="md"
                            placeholder="Value"
                            class="mt-[5px]"
                        />
                    </u-form-group>

                    <u-form-group name="value" label="Value" class="w-1/2">
                        <u-input
                            v-model="setting.value"
                            color="blue"
                            size="md"
                            placeholder="Value"
                        />

                        <template #hint>
                            <u-button
                                icon="i-heroicons-x-mark-20-solid"
                                :padded="false"
                                color="gray"
                                variant="link"
                                size="xs"
                                @click="removeOption(index)"
                            />
                        </template>
                    </u-form-group>
                </div>
            </div>

            <div class="flex gap-2">
                <u-button
                    icon="material-symbols:save"
                    size="md"
                    color="blue"
                    label="Add Setting"
                    @click="addOption"
                />

                <u-button
                    icon="material-symbols:save"
                    type="submit"
                    size="md"
                    color="blue"
                    label="Save"
                    :loading="loading"
                    @click="save"
                />
            </div>
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
    settings: [] as MarketplaceAccountSetting[],
});

const marketplaceOptions = [
    { value: 'wildberries', label: 'Wildberries' },
    { value: 'ozon', label: 'Ozon' },
    { value: 'yandex', label: 'Yandex Market' },
];

const addOption = () => {
    account.settings.push({
        key: '',
        value: '',
    });
};

const removeOption = (index: number) => {
    account.settings.splice(index, 1);
};

const save = async () => {
    loading.value = true;

    await apiFetch(`v1/marketplaces/accounts`, {
        method: 'POST',
        body: account,
    });

    $notify('Marketplace account created successfully', 'success');
    loading.value = false;
};
</script>
