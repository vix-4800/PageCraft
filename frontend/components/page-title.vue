<template>
    <div class="flex flex-col items-center px-6 mb-8 text-center">
        <h2 class="text-3xl font-bold text-gray-800">
            {{ title }}
        </h2>

        <p v-if="subtitle" class="max-w-3xl mt-2 text-sm text-gray-500">
            {{ subtitle }}
        </p>
    </div>
</template>

<script lang="ts" setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        required: false,
        default: '',
    },
});
</script>
