<template>
    <u-link
        :to="
            to === 'dashboard' || to === 'logout'
                ? '/' + to
                : '/dashboard/' + to
        "
        active-class="text-indigo-500 bg-indigo-100 hover:bg-indigo-100 hover:text-indigo-600"
        class="group flex items-center justify-between gap-2 rounded-md px-2.5 py-2 text-sm text-slate-800 font-semibold hover:bg-slate-200 hover:text-slate-900"
    >
        <div class="flex group-hover:text-indigo-500">
            <slot>
                <!-- Icon slot -->
            </slot>
        </div>

        <span class="grow">
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
