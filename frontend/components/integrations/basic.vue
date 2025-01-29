<template>
    <div class="relative w-full px-4 mx-auto max-w-7xl md:px-5 lg:px-5">
        <div
            class="inline-flex flex-col items-center justify-start w-full gap-8 lg:gap-11"
        >
            <div
                class="grid items-start justify-start grid-cols-1 gap-8 lg:grid-cols-4 md:grid-cols-2"
            >
                <u-button
                    v-for="integration in integrations"
                    :key="integration.name"
                    :to="integration.link"
                    size="lg"
                    variant="ghost"
                    target="_blank"
                    color="indigo"
                    class="w-full px-6 py-8 h-full rounded-2xl border border-gray-200 hover:border-indigo-600 transition-all duration-300 ease-in-out justify-center items-center gap-2.5 flex"
                >
                    <div
                        class="flex-col justify-start items-center gap-3.5 inline-flex"
                    >
                        <u-icon :name="integration.icon" class="w-16 h-12" />

                        <p
                            class="text-sm font-normal leading-snug text-center text-gray-500"
                        >
                            {{ integration.description }}
                        </p>
                    </div>
                </u-button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps({
    integrations: {
        type: Array as () => {
            name: string;
            description: string;
            link: string;
            icon: string;
        },
        required: true,
    },
});
</script>
