<template>
    <footer
        class="bg-gradient-to-br from-gray-900 to-gray-700 p-10 font-[sans-serif] tracking-wide"
    >
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="lg:flex lg:items-center">
                <nuxt-link to="/" class="flex items-center gap-4 group">
                    <nuxt-img
                        src="/logo.png"
                        :alt="appName"
                        width="40px"
                        height="40px"
                    />
                    <span
                        class="text-2xl font-bold text-white group-hover:text-yellow-500"
                    >
                        {{ appName }}
                    </span>
                </nuxt-link>
            </div>

            <div class="lg:flex lg:items-center">
                <ul class="flex space-x-1">
                    <li>
                        <u-button
                            to="/"
                            size="lg"
                            icon="mdi:instagram"
                            class="bg-transparent hover:bg-transparent hover:text-yellow-500"
                        />
                    </li>
                    <li>
                        <u-button
                            to="/"
                            size="lg"
                            icon="mdi:facebook"
                            class="bg-transparent hover:bg-transparent hover:text-yellow-500"
                        />
                    </li>
                    <li>
                        <u-button
                            to="/"
                            size="lg"
                            icon="mdi:twitter"
                            class="bg-transparent hover:bg-transparent hover:text-yellow-500"
                        />
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="mb-6 text-lg font-semibold text-white">
                    Contact Us
                </h4>
                <ul class="space-y-4">
                    <li>
                        <a
                            href="mailto:test@example.com"
                            class="text-sm text-gray-300 hover:text-yellow-500"
                        >
                            Email
                        </a>
                    </li>
                    <li>
                        <a
                            href="javascript:void(0)"
                            class="text-sm text-gray-300 hover:text-yellow-500"
                        >
                            Phone
                        </a>
                    </li>
                    <li>
                        <a
                            href="javascript:void(0)"
                            class="text-sm text-gray-300 hover:text-yellow-500"
                        >
                            Address
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="mb-6 text-lg font-semibold text-white">
                    Information
                </h4>
                <ul class="space-y-4">
                    <li v-for="page in footerPages" :key="page.name">
                        <nuxt-link
                            :to="page.href"
                            class="text-sm text-gray-300 hover:text-yellow-500"
                        >
                            {{ page.name }}
                        </nuxt-link>
                    </li>
                </ul>
            </div>
        </div>

        <p class="mt-10 text-sm text-gray-300">
            ©{{ appName }}. All rights reserved.
        </p>
    </footer>
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
});
</script>
