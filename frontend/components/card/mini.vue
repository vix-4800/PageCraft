<template>
    <div
        class="p-6 bg-white border rounded-lg border-slate-200 sm:col-span-6 xl:col-span-3"
    >
        <dl>
            <dt class="text-2xl font-bold" :class="`text-${valueColor}`">
                {{ value }}
            </dt>
            <dd class="text-sm font-medium text-slate-500">
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
