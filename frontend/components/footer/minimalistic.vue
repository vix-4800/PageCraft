<template>
    <div class="px-16 py-6 font-sans tracking-wide text-gray-300 bg-gray-900">
        <div
            class="flex flex-wrap items-center justify-between gap-4 text-center max-lg:flex-col"
        >
            <p class="text-[15px] leading-loose">
                © {{ appName }}. All rights reserved.
            </p>

            <ul class="flex flex-wrap space-x-6 gap-y-2 max-lg:justify-center">
                <li v-for="page in footerPages" :key="page.name">
                    <nuxt-link
                        :to="page.href"
                        class="text-[15px] hover:text-white"
                    >
                        {{ page.name }}
                    </nuxt-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
const appName: string = useRuntimeConfig().public.appName;

defineProps({
    footerPages: {
        type: Array as () => {
            name: string;
            href: string;
        }[],
        required: true,
    },
    footerContacts: {
        type: Object as () => {
            email: string;
            phone: string;
            address: string;
        },
        required: true,
    },
});
</script>
