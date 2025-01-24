<template>
    <div>
        <dashboard-page-name title="Users" />

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
            :empty-state="{
                icon: 'material-symbols:groups',
                label: 'No users',
            }"
            @select="select"
        />

        <div
            class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
        >
            <u-pagination
                v-model="page"
                :active-button="{ variant: 'outline', color: 'blue' }"
                :inactive-button="{ color: 'gray' }"
                :total="total"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Meta } from '~/types/pagination';
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

const page = ref(1);
const total = ref(0);

onMounted(async () => {
    await getUsers();
});

watch(page, async () => {
    await getUsers();
});

function select(row: User) {
    return navigateTo('/dashboard/admin/users/' + row.id);
}

async function getUsers() {
    const { data, meta } = await apiFetch<{ data: User[]; meta: Meta }>(
        `v1/users`,
        {
            params: {
                page: page.value,
            },
        }
    );

    users.value = data;
    status.value = 'success';

    page.value = meta.current_page;
    total.value = meta.total;
}
</script>
