<template>
    <div
        v-if="users"
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Registered Users</h2>
            <!-- <h3 class="text-sm font-medium text-slate-500"></h3> -->
        </div>
        <div class="p-6">
            <div class="min-w-full overflow-x-auto rounded">
                <table class="min-w-full text-sm align-middle">
                    <thead>
                        <tr class="border-b-2 border-slate-100">
                            <th
                                class="px-3 py-2 text-sm font-semibold tracking-wider uppercase text-start text-slate-700"
                            >
                                id
                            </th>
                            <th
                                class="hidden px-3 py-2 text-sm font-semibold tracking-wider uppercase text-start text-slate-700 md:table-cell"
                            >
                                Name
                            </th>
                            <th
                                class="hidden px-3 py-2 text-sm font-semibold tracking-wider uppercase text-start text-slate-700 md:table-cell"
                            >
                                Email
                            </th>
                            <th
                                class="hidden px-3 py-2 text-sm font-semibold tracking-wider uppercase text-start text-slate-700 md:table-cell"
                            >
                                Status
                            </th>
                            <th
                                class="px-3 py-2 text-sm font-semibold tracking-wider uppercase text-end text-slate-700"
                            >
                                Phone
                            </th>
                            <th
                                class="px-3 py-2 text-sm font-semibold tracking-wider uppercase text-end text-slate-700"
                            >
                                Registered At
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td class="p-3 text-start">
                                <a
                                    class="font-medium text-indigo-500 hover:text-indigo-700"
                                    href="javascript:void(0)"
                                >
                                    {{ user.id }}
                                </a>
                            </td>
                            <td class="hidden p-3 text-slate-600 md:table-cell">
                                {{ user.email }}
                            </td>
                            <td class="hidden p-3 text-slate-600 md:table-cell">
                                {{ user.name }}
                            </td>
                            <td class="hidden p-3 text-start md:table-cell">
                                <div
                                    class="inline-block px-2 py-1 text-xs font-semibold leading-4 border rounded-full"
                                    :class="{
                                        'text-orange-700 border-orange-200 bg-orange-50':
                                            !user.is_email_verified,
                                        'text-green-700 border-green-200 bg-green-50':
                                            user.is_email_verified,
                                    }"
                                >
                                    {{
                                        user.is_email_verified
                                            ? 'Verified'
                                            : 'Not Verified'
                                    }}
                                </div>
                            </td>
                            <td class="p-3 font-medium text-end">
                                {{ user.phone }}
                            </td>
                            <td class="p-3 font-medium text-end">
                                {{ user.registered_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { User } from '~/types/user';

definePageMeta({
    layout: 'dashboard',
});

const apiUrl: string = useRuntimeConfig().public.apiUrl;

const users = ref<User[]>([]);
onMounted(async () => {
    const response: { data: User[] } = await $fetch<{ data: User[] }>(
        `${apiUrl}/v1/users`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                Authorization: `Bearer 1|hNyKEQRimoRPVECPU7jhaQYTzkJFNFO6DLtRTavyc13477d3`,
            },
        }
    ).catch((error) => error.data);

    users.value = response.data;
});
</script>
