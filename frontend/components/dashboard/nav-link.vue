<template>
    <nuxt-link
        :to="
            to === 'dashboard' || to === 'logout'
                ? '/' + to
                : '/dashboard/' + to
        "
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
    </nuxt-link>
</template>

<script lang="ts" setup>
defineProps<{
    to: string;
    label: string;
    helper?: string;
}>();
</script>

<style scoped>
.router-link-exact-active {
    @apply bg-indigo-100 text-indigo-500 hover:bg-indigo-100 hover:text-indigo-600;
}
</style>
