<template>
    <div
        v-if="show"
        class="flex items-center max-md:flex-col gap-6 bg-gradient-to-tr from-yellow-700 to-yellow-400 text-white px-6 py-3.5 font-[sans-serif]"
    >
        <p class="flex-1 text-base max-md:text-center">
            {{ text }}
        </p>

        <div v-if="link">
            <u-button
                label="Get Offer"
                icon="material-symbols:arrow-right-alt-rounded"
                size="md"
                color="white"
                :to="link"
            />
        </div>

        <u-button
            icon="i-heroicons-x-mark-20-solid"
            size="md"
            color="black"
            class="bg-transparent border-0 hover:bg-transparent hover:text-white"
            @click="show = false"
        />
    </div>
</template>

<script lang="ts" setup>
defineProps({
    text: {
        type: String,
        required: true,
    },
    link: {
        type: String,
        required: false,
        default: null,
    },
});

const show = ref(true);
</script>
