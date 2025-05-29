<template>
    <div class="flex justify-center w-full bg-white py-7">
        <nav class="flex gap-12 text-base font-light text-gray-700">
            <u-link
                v-for="page in headerPages"
                :key="page.name"
                :to="page.href"
                class="hover:underline"
            >
                {{ page.name }}
            </u-link>
        </nav>
    </div>
</template>

<script lang="ts" setup>
defineProps({
    headerPages: {
        type: Array as () => {
            name: string;
            href: string;
            icon: string;
        }[],
        required: true,
    },
});

const authStore = useAuthStore();
const appName: string = useRuntimeConfig().public.appName;
</script>
