<template>
    <div>
        <dashboard-page-name title="Application">
            <template #actions>
                <u-button
                    v-if="selected === 'system-monitoring'"
                    color="blue"
                    size="md"
                    icon="material-symbols:refresh"
                    label="Refresh"
                    @click="refreshStats"
                />

                <u-button
                    v-if="selected === 'backups'"
                    color="blue"
                    size="md"
                    icon="material-symbols:add"
                    label="Create"
                    @click="createBackup"
                />

                <u-button
                    v-if="selected === 'backups'"
                    color="red"
                    size="md"
                    icon="material-symbols:delete"
                    label="Delete All"
                    @click="deleteAllBackups"
                />

                <u-button
                    v-if="selected === 'application-logs'"
                    color="red"
                    size="md"
                    icon="material-symbols:delete"
                    label="Clear"
                    @click="clearAppLogs"
                />

                <u-button
                    v-if="selected === 'queue-logs'"
                    color="red"
                    size="md"
                    icon="material-symbols:delete"
                    label="Clear"
                    @click="clearQueueLogs"
                />
            </template>
        </dashboard-page-name>

        <u-tabs :items="items" class="w-full" @change="onChange">
            <template #item="{ item }">
                <system-monitoring-resources
                    v-if="item.key === 'system-monitoring'"
                />

                <system-monitoring-backups v-if="item.key === 'backups'" />

                <system-monitoring-application-logs
                    v-if="item.key === 'application-logs'"
                />

                <system-monitoring-queue-logs
                    v-if="item.key === 'queue-logs'"
                />
            </template>
        </u-tabs>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const selected = ref('system-monitoring');

const items = [
    {
        key: 'system-monitoring',
        label: 'System Monitoring',
        icon: 'material-symbols:system-update',
        description: 'Monitor your system resources (CPU, RAM, Network).',
    },
    {
        key: 'backups',
        label: 'Backups',
        icon: 'material-symbols:cloud-download',
        description: 'Manage your application backups.',
    },
    {
        key: 'application-logs',
        label: 'Application Logs',
        icon: 'material-symbols:bug-report',
        description: 'View your application logs.',
    },
    {
        key: 'queue-logs',
        label: 'Queue Logs',
        icon: 'material-symbols:timeline',
        description: 'View your application queue logs.',
    },
];

const onChange = (index) => {
    selected.value = items[index].key;
};

const refreshStats = () => {
    window.dispatchEvent(new CustomEvent('stats:refresh'));
};

const createBackup = () => {
    window.dispatchEvent(new CustomEvent('backup:create'));
};

const deleteAllBackups = () => {
    window.dispatchEvent(new CustomEvent('backup:delete-all'));
};

const clearAppLogs = () => {
    window.dispatchEvent(new CustomEvent('app-logs:clear'));
};

const clearQueueLogs = () => {
    window.dispatchEvent(new CustomEvent('queue-logs:clear'));
};
</script>
