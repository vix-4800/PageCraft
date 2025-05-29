<template>
    <div class="flex justify-center bg-[#f7f7f7]">
        <div
            class="flex items-center justify-between w-full px-6 py-6 max-w-7xl"
        >
            <div class="flex items-center gap-6">
                <nuxt-link to="/" class="text-2xl font-bold tracking-widest">
                    {{ appName }}
                </nuxt-link>
                <nav class="hidden gap-8 ml-8 text-sm font-medium md:flex">
                    <u-link
                        v-for="page in headerPages"
                        :key="page.name"
                        :to="page.href"
                        active-class="text-orange-400"
                        inactive-class="text-gray-700"
                        class="hover:underline"
                    >
                        {{ page.name }}
                    </u-link>
                </nav>
            </div>
            <div class="flex items-center gap-6">
                <!-- Heart Icon -->
                <nuxt-link
                    to="/products/favorites"
                    class="p-2 transition rounded-full hover:bg-gray-200"
                >
                    <svg
                        width="22"
                        height="22"
                        fill="none"
                        stroke="currentColor"
                    >
                        <path
                            d="M16.5 4.75a4.38 4.38 0 00-6.19 0L10 5.06l-.31-.31A4.38 4.38 0 003.5 4.75 4.5 4.5 0 003.5 11l6.44 6.43a1.12 1.12 0 001.62 0L18.5 11A4.5 4.5 0 0016.5 4.75z"
                            stroke-width="1.5"
                        />
                    </svg>
                </nuxt-link>

                <!-- Cart Icon -->
                <nuxt-link
                    to="/cart"
                    class="p-2 transition rounded-full hover:bg-gray-200"
                >
                    <svg
                        width="22"
                        height="22"
                        fill="none"
                        stroke="currentColor"
                    >
                        <path
                            d="M3 6h16l-1.5 9.5a2 2 0 01-2 1.5H7a2 2 0 01-2-1.5L3 6zm0 0L2 3m1 3h16m-10 9a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2z"
                            stroke-width="1.5"
                        />
                    </svg>
                </nuxt-link>
            </div>
        </div>
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
