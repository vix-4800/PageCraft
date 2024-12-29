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
                        <span
                            class="text-2xl font-bold text-white group-hover:text-indigo-300"
                        >
                            {{ appName }}
                        </span>
                    </nuxt-link>
                </div>

                <div class="flex items-center gap-1 lg:gap-5">
                    <nav class="flex items-center gap-2">
                        <u-button
                            class="font-semibold bg-transparent hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200 active:bg-indigo-100"
                            size="md"
                            icon="ic:baseline-notifications"
                            :label="notifications.length.toString()"
                            @click="isNotificationSlideOverOpen = true"
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
                        to="/dashboard/orders"
                        class="group flex items-center justify-between gap-2 rounded-md border border-transparent px-2.5 py-2 text-sm font-semibold text-slate-400 hover:bg-indigo-100 hover:text-indigo-600 active:border-indigo-200"
                    >
                        <u-icon
                            name="material-symbols:shopping-cart"
                            size="20"
                            class="text-slate-400 group-hover:text-indigo-500"
                        />
                        <span class="grow">Orders</span>
                        <span
                            class="inline-flex items-center justify-center px-1 text-xs text-indigo-900 border border-indigo-200 rounded-full bg-indigo-50"
                        >
                            0
                        </span>
                    </nuxt-link>
                </div>
            </nav>
        </div>
    </header>

    <u-slideover v-model="isNotificationSlideOverOpen">
        <div class="flex-1 p-4 bg-slate-400">
            <u-card
                class="flex flex-col flex-1 shadow-sm bg-slate-200"
                :ui="{
                    body: { base: 'flex-1' },
                    ring: '',
                    divide: 'divide-y divide-gray-100 dark:divide-gray-800',
                }"
            >
                <template #header>
                    <u-button
                        color="gray"
                        variant="ghost"
                        size="sm"
                        icon="i-heroicons-x-mark-20-solid"
                        class="absolute z-10 flex sm:hidden end-5 top-5"
                        square
                        padded
                        @click="isNotificationSlideOverOpen = false"
                    />

                    <h3 class="text-2xl font-semibold">Notifications</h3>
                    <p
                        v-if="notifications.length > 0"
                        class="text-gray-600 text-md"
                    >
                        You have
                        <span class="font-semibold">
                            {{ notifications.length }}
                        </span>
                        unread notifications
                    </p>
                    <p v-else class="text-gray-600 text-md">
                        You don't have any new notifications
                    </p>
                </template>

                <div class="h-full space-y-2 overflow-y-auto">
                    <u-button
                        v-for="notification in notifications"
                        :key="notification.id"
                        class="flex items-center w-full gap-2 p-3 border rounded-lg shadow-sm border-slate-200 hover:bg-slate-100"
                        :label="notification.data.message"
                        icon="heroicons-outline:check-circle"
                        color="gray"
                        @click="readNotification(notification)"
                    />
                </div>
            </u-card>
        </div>
    </u-slideover>
</template>

<script lang="ts" setup>
const config = useRuntimeConfig();
const appName: string = config.public.appName;

const authStore = useAuthStore();
const userName = computed(() => authStore.user?.name || 'User');

const isNotificationSlideOverOpen = ref(false);
const notifications = ref<Notification[]>([]);

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

onMounted(async () => {
    const { data } = await apiFetch<{ data: Notification[] }>(
        `user/notifications`
    );

    notifications.value = data;
});

const readNotification = async (notification: Notification) => {
    const { data } = await apiFetch<{ data: Notification[] }>(
        `user/notifications/${notification.id}`,
        {
            method: 'PATCH',
        }
    );

    notifications.value = data;

    navigateTo('/dashboard/orders/' + notification.data.order.id);

    isNotificationSlideOverOpen.value = false;
};

const mobileNavOpen = ref(false);
</script>
