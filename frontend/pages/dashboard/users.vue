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
                                    class="inline-block px-2 py-1 text-xs font-semibold leading-4 text-orange-700 border border-orange-200 rounded-full bg-orange-50"
                                >
                                    {{ user.status }}
                                </div>
                            </td>
                            <td class="p-3 font-medium text-end">
                                {{ user.phone }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
});

const config = useRuntimeConfig();
const apiUrl = config.public.apiUrl;

const { data: users } = await useFetch(apiUrl + '/v1/users');
</script>
