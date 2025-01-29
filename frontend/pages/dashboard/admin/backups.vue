<template>
    <div>
        <dashboard-page-name title="Application Backups">
            <template #actions>
                <u-button
                    color="blue"
                    size="md"
                    icon="material-symbols:add"
                    label="Create"
                    :loading="creating"
                    @click="createBackup"
                />

                <u-button
                    v-if="backups.length > 0"
                    color="red"
                    size="md"
                    icon="material-symbols:delete"
                    :loading="deleting"
                    label="Delete All"
                    @click="deleteBackups"
                />
            </template>
        </dashboard-page-name>

        <u-table
            :columns="columns"
            :rows="backups"
            :loading="loading"
            :loading-state="{
                icon: 'i-heroicons-arrow-path-20-solid',
                label: 'Loading...',
            }"
            :progress="{ color: 'blue', animation: 'carousel' }"
            class="w-full"
            :empty-state="{
                icon: 'material-symbols:info',
                label: 'No backups',
            }"
        />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const columns = [
    {
        key: 'date',
        label: 'Date',
        sortable: true,
    },
    {
        key: 'name',
        label: 'Name',
    },
    {
        key: 'size',
        label: 'Size',
        sortable: true,
    },
];

const { $notify } = useNuxtApp();

const loading = ref(false);
const backups = ref([]);
onMounted(async () => {
    await fetchBackups();
});

const fetchBackups = async () => {
    loading.value = true;

    const { data } = await apiFetch('v1/backups');

    backups.value = data;
    loading.value = false;
};

const deleting = ref(false);
const deleteBackups = async () => {
    deleting.value = true;

    try {
        withPasswordConfirmation(
            async () => {
                await apiFetch('v1/backups', {
                    method: 'DELETE',
                });

                $notify('Backups cleared successfully', 'success');
                backups.value = [];
            },
            'Confirm backups deletion',
            'Are you sure you want to delete all backups?',
            true
        );
    } catch (error) {
        console.error(error);

        $notify('Error clearing backups', 'error');
    } finally {
        deleting.value = false;
    }
};

const creating = ref(false);
const createBackup = async () => {
    creating.value = true;

    try {
        await apiFetch('v1/backups', {
            method: 'POST',
        });

        $notify('Backup created successfully', 'success');

        await fetchBackups();
    } catch (error) {
        console.error(error);

        $notify('Failed to create backup', 'error');
    } finally {
        creating.value = false;
    }
};
</script>
