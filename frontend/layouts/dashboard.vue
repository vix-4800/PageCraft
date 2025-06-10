<template>
    <div>
        <header-dashboard :pages="pages" />

        <div
            class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-slate-100 dark:bg-slate-700"
        >
            <div class="flex flex-col flex-auto max-w-full">
                <div class="container p-4 mx-auto lg:p-8 xl:max-w-7xl">
                    <div class="grid grid-cols-1 md:gap-20 lg:grid-cols-12">
                        <dashboard-sidebar :categories="categories" />

                        <main class="lg:col-span-9">
                            <div v-if="showWelcomeMessage" class="p-6">
                                <p class="text-2xl font-semibold">
                                    С возвращением,
                                    <span
                                        class="text-indigo-600 dark:text-indigo-400"
                                    >
                                        {{ authStore.user.name }}!
                                    </span>
                                </p>
                            </div>

                            <div
                                class="p-6 overflow-hidden bg-white border dark:border-0 dark:bg-slate-600 rounded-xl border-slate-200"
                            >
                                <slot></slot>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <footer-dashboard />
    </div>
</template>

<script lang="ts" setup>
import { AdminPages, SharedPages } from '~/config/dashboard-pages';

const authStore = useAuthStore();
const route = useRoute();

const showWelcomeMessage = computed(() =>
    ['/dashboard/admin', '/dashboard/user'].includes(route.fullPath)
);

const categories = {
    Dashboard: [
        {
            label: 'Главная',
            icon: 'material-symbols:dashboard',
            href: authStore.isAdmin ? '/dashboard/admin' : '/dashboard/user',
        },
    ],
    ...SharedPages,
    ...(authStore.isAdmin ? AdminPages : []),
};

const pages = computed(() => {
    return Object.values(categories).flat();
});
</script>
