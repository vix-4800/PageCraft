<template>
    <u-slideover>
        <div class="flex-1 p-4 overflow-y-auto bg-slate-400">
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
                        @click="slideover.close()"
                    />

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-semibold">
                                Notifications
                            </h3>
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
                        </div>

                        <u-tooltip
                            v-if="notifications.length > 0"
                            text="Mark all as read"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                class="hidden sm:flex"
                                color="gray"
                                variant="ghost"
                                icon="material-symbols:mark-chat-read"
                                square
                                padded
                                @click="readAll"
                            />
                        </u-tooltip>
                    </div>
                </template>

                <div v-auto-animate class="h-full space-y-2 overflow-y-auto">
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
import type { Notification } from '~/types/notification';

const slideover = useSlideover();

onMounted(async () => {
    const { data } = await apiFetch<{ data: Notification[] }>(
        `user/notifications`
    );

    notifications.value = data;
});

const notifications = ref<Notification[]>([]);

const readNotification = async (notification: Notification) => {
    const { data } = await apiFetch<{ data: Notification[] }>(
        `user/notifications/${notification.id}`,
        {
            method: 'PATCH',
        }
    );

    notifications.value = data;

    switch (notification.data.type) {
        case 'order':
            navigateTo(
                `/dashboard/admin/orders/${notification.data.details.id}`
            );
            break;
        case 'feedback_message':
            navigateTo(
                `/dashboard/admin/questions/${notification.data.details.id}`
            );
            break;
        case 'database_backup':
            navigateTo(`/dashboard/admin/backups`);
            break;
        default:
            break;
    }

    slideover.close();
};

const readAll = async () => {
    await apiFetch<{ data: Notification[] }>(`user/notifications`, {
        method: 'PATCH',
    });

    notifications.value = [];
};
</script>
