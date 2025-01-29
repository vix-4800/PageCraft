<template>
    <div
        class="flex text-center items-center max-md:flex-col gap-6 bg-gradient-to-tr from-red-700 to-red-400 text-white px-6 py-3.5 font-[sans-serif]"
    >
        <p class="flex-1 text-base font-semibold">
            {{ text }}
        </p>
    </div>
</template>

<script setup lang="ts">
defineProps({
    text: {
        type: String,
        required: true,
    },
});
</script>
