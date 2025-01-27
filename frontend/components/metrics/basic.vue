<template>
    <div class="grid gap-6 lg:grid-cols-4 sm:grid-cols-2 max-lg:gap-12">
        <div v-for="stat in stats" :key="stat.label" class="text-center">
            <h3 class="text-4xl font-extrabold text-gray-800">
                {{ stat.value
                }}<span class="text-blue-600">{{ stat.suffix }}</span>
            </h3>
            <p class="mt-4 text-base font-bold">{{ stat.label }}</p>
            <p class="mt-2 text-sm text-gray-500">
                {{ stat.description }}
            </p>
        </div>
    </div>
</template>

<script lang="ts" setup>
defineProps({
    stats: {
        type: Array,
        required: true,
    },
});
</script>
