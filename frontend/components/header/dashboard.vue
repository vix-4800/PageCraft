<template>
    <header
        class="flex items-center flex-none z-1 bg-gradient-to-br from-gray-900 to-gray-700"
    >
        <div class="container px-4 mx-auto lg:px-8 xl:max-w-7xl">
            <div class="flex justify-between py-6">
                <div class="flex items-center">
                    <nuxt-link
                        to="/"
                        class="inline-flex items-center gap-1 font-bold tracking-wide group text-md text-slate-700 hover:text-indigo-600 active:text-slate-700 sm:text-lg"
                    >
                        <nuxt-img
                            src="/logo.png"
                            :alt="appName"
                            width="40px"
                            height="40px"
                        />
                        <u-chip
                            size="lg"
                            :color="
                                settingStore.isMaintenance ? 'red' : 'green'
                            "
                            :ui="{ base: '-mx-2 ring-0' }"
                        >
                            <span
                                class="text-2xl font-bold text-white group-hover:text-indigo-300"
                            >
                                {{ appName }}
                            </span>
                        </u-chip>
                    </nuxt-link>
                </div>

                <inputs-page-search :pages="pages" />

                <div class="flex items-center gap-1 lg:gap-5">
                    <nav class="flex items-center gap-2">
                        <u-button
                            class="font-semibold bg-transparent hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 active:bg-indigo-100"
                            size="md"
                            icon="ic:baseline-notifications"
                            @click="slideover.open(Notifications)"
                        />
                    </nav>

                    <div class="relative inline-block">
                        <u-dropdown
                            :items="userDropdownItems"
                            :popper="{ placement: 'bottom-start' }"
                        >
                            <u-button
                                size="md"
                                :label="userName"
                                class="font-semibold bg-transparent hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 active:bg-indigo-100"
                                trailing-icon="i-heroicons-chevron-down-20-solid"
                            />
                        </u-dropdown>
                    </div>

                    <div class="lg:hidden">
                        <u-button
                            class="bg-transparent hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 active:bg-indigo-100"
                            icon="material-symbols:menu"
                            size="md"
                            @click="mobileNavOpen = !mobileNavOpen"
                        />
                    </div>
                </div>
            </div>

            <nav
                v-show="mobileNavOpen"
                role="navigation"
                class="flex flex-col py-4 lg:hidden"
            >
                <div class="space-y-1.5">
                    <nuxt-link
                        v-for="link in mobileNavLinks"
                        :key="link.label"
                        :to="link.to"
                        class="group flex items-center justify-between gap-2 rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-400 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200"
                    >
                        <u-icon
                            :name="link.icon"
                            size="20"
                            class="text-slate-400 group-hover:text-indigo-500"
                        />
                        <span class="grow">
                            {{ link.label }}
                        </span>
                        <span
                            class="inline-flex items-center justify-center px-1 text-xs text-indigo-900 border border-indigo-200 rounded-full bg-indigo-50"
                        >
                            {{ link.badge }}
                        </span>
                    </nuxt-link>
                </div>
            </nav>
        </div>
    </header>
</template>

<script lang="ts" setup>
import Notifications from '~/components/slideovers/notifications.vue';

defineProps({
    pages: {
        type: Object as () => { label: string; href: string }[],
        required: true,
    },
});

const config = useRuntimeConfig();

const authStore = useAuthStore();
const settingStore = useSiteSettingsStore();

const userName = computed(() => authStore.user?.name || 'User');
const appName: string = config.public.appName;

const slideover = useSlideover();

const userDropdownItems = [
    [
        {
            label: 'Account',
            icon: 'material-symbols:account-circle',
            to: '/dashboard/account',
        },
    ],
    [
        {
            label: 'Logout',
            icon: 'material-symbols:logout-rounded',
            click: () => {
                authStore.logout();
            },
        },
    ],
];

const mobileNavOpen = ref(false);
const mobileNavLinks = [
    {
        label: 'Orders',
        icon: 'material-symbols:shopping-cart',
        to: '/dashboard/admin/orders',
        badge: 0,
    },
];
</script>
