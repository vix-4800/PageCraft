<template>
    <div
        class="p-6 bg-white border rounded-lg dark:bg-slate-700 dark:border-0 border-slate-200 sm:col-span-6 xl:col-span-3"
    >
        <dl>
            <dt
                class="text-2xl font-bold dark:text-slate-200"
                :class="`text-${valueColor}`"
            >
                {{ value }}
            </dt>
            <dd class="text-sm font-medium text-slate-500 dark:text-slate-300">
                {{ label }}
            </dd>
        </dl>
    </div>
</template>

<script lang="ts" setup>
defineProps({
    value: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    valueColor: {
        type: String,
        default: 'black',
    },
});
</script>
