<template>
    <div
        class="mb-4 text-2xl font-semibold leading-9 text-gray-500 font-manrope"
    >
        <div
            class="flex flex-col items-center justify-between w-full gap-3 sm:flex-row"
        >
            <div
                class="inline-flex flex-col items-center justify-center w-full gap-1 sm:items-start"
            >
                <h2
                    class="text-2xl font-semibold leading-9 text-gray-500 font-manrope"
                >
                    {{ title }}
                    <span v-if="subtitle" class="text-indigo-600">
                        {{ subtitle }}
                    </span>
                </h2>
                <span
                    v-if="description"
                    class="text-base font-medium leading-relaxed text-gray-500"
                >
                    {{ description }}
                </span>
            </div>

            <slot name="actions"></slot>
        </div>
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
    description: {
        type: String,
        required: false,
        default: '',
    },
});
</script>
