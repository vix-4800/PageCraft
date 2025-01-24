<template>
    <div class="space-y-2">
        <h1 class="text-3xl font-bold text-center">
            {{ title }}
        </h1>

        <p v-if="subtitle" class="text-center">
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
