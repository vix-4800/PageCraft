<template>
    <u-link
        :to="to"
        active-class="text-indigo-500 bg-indigo-100 dark:text-indigo-500 dark:bg-slate-800 hover:bg-indigo-100 hover:text-indigo-600"
        inactive-class="text-slate-800 dark:text-slate-100 hover:bg-slate-200 dark:hover:bg-slate-800 hover:text-slate-900"
        class="group flex items-center justify-between gap-2 rounded-md px-2.5 py-2 text-sm font-semibold"
    >
        <div class="flex group-hover:text-indigo-500">
            <slot>
                <!-- Icon slot -->
            </slot>
        </div>

        <span class="grow group-hover:text-indigo-500">
            {{ label }}
        </span>

        <span
            v-if="helper"
            class="inline-flex items-center justify-center px-1 text-xs text-indigo-900 border border-indigo-200 rounded-full bg-indigo-50"
        >
            {{ helper }}
        </span>
    </u-link>
</template>

<script lang="ts" setup>
defineProps<{
    to: string;
    label: string;
    helper?: string;
}>();
</script>
