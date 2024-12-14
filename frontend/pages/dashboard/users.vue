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
                    :loading="status === 'pending' || status === 'idle'"
                    :loading-state="{
                        icon: 'i-heroicons-arrow-path-20-solid',
                        label: 'Loading...',
                    }"
                    :progress="{ color: 'primary', animation: 'carousel' }"
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

const authStore = useAuthStore();
const apiUrl: string = useRuntimeConfig().public.apiUrl;

const users = ref<User[]>([]);
const status = ref('idle');
onMounted(async () => {
    const response: { data: User[] } = await $fetch<{ data: User[] }>(
        `${apiUrl}/v1/users`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                Authorization: `Bearer ${authStore.authToken}`,
            },
            onRequest() {
                status.value = 'pending';
            },
            onResponse() {
                status.value = 'success';
            },
        }
    );

    users.value = response.data;
});
</script>
