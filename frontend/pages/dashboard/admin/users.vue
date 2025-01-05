<template>
    <div>
        <DashboardPageName title="Users" />

        <u-table
            :columns="columns"
            :rows="users"
            :loading="status === 'pending'"
            :loading-state="{
                icon: 'i-heroicons-arrow-path-20-solid',
                label: 'Loading...',
            }"
            :progress="{ color: 'blue', animation: 'carousel' }"
            class="w-full"
        />
    </div>
</template>

<script lang="ts" setup>
import type { User } from '~/types/user';

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
        key: 'email',
        label: 'Email',
        sortable: true,
    },
    {
        key: 'phone',
        label: 'Phone',
    },
    {
        key: 'is_email_verified',
        label: 'Is Verified',
        sortable: true,
    },
    {
        key: 'registered_at',
        label: 'Registered At',
    },
];

const users = ref<User[]>([]);
const status = ref('pending');
onMounted(async () => {
    const response: { data: User[] } = await apiFetch<{ data: User[] }>(
        `v1/users`
    );

    users.value = response.data;
    status.value = 'success';
});
</script>
