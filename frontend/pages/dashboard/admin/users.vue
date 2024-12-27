<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Registered Users</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full overflow-x-auto rounded">
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
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { User } from '~/types/user';

definePageMeta({
    layout: 'dashboard',
    middleware: ['verified'],
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
