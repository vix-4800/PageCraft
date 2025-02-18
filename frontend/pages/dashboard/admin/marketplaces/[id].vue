<template>
    <div>
        <dashboard-page-name
            title="Marketplace Account"
            :subtitle="account?.marketplace"
            :description="`Created on ${account?.created_at || ''}`"
        >
            <template #actions>
                <u-button
                    color="red"
                    size="md"
                    icon="material-symbols:delete"
                    label="Delete Account"
                    @click="deleteAccount"
                />
            </template>
        </dashboard-page-name>

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
        body: account.value,
    });

    $notify('Marketplace account updated successfully', 'success');
    loading.value = false;
};

const deleteAccount = async () => {
    withPasswordConfirmation(
        async () => {
            loading.value = true;

            await apiFetch(`v1/marketplaces/accounts/${route.params.id}`, {
                method: 'DELETE',
            });

            loading.value = false;
            navigateTo('/dashboard/admin/marketplaces');
            $notify('Marketplace account deleted', 'success');
        },
        'Confirm marketplace account deletion',
        'Are you sure you want to delete this account?',
        true
    );
};
</script>
