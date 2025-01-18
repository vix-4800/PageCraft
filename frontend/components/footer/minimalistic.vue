<template>
    <footer
        class="px-16 py-6 font-sans tracking-wide text-gray-300 bg-gray-900"
    >
        <div
            class="flex flex-wrap items-center justify-between gap-4 text-center max-lg:flex-col"
        >
            <p class="text-[15px] leading-loose">
                © {{ appName }}. All rights reserved.
            </p>

            <ul class="flex flex-wrap space-x-6 gap-y-2 max-lg:justify-center">
                <li>
                    <nuxt-link to="/terms" class="text-[15px] hover:text-white">
                        Terms of Service
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link
                        to="/privacy"
                        class="text-[15px] hover:text-white"
                    >
                        Privacy Policy
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link
                        to="/contact"
                        class="text-[15px] hover:text-white"
                    >
                        Contact
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link to="/about" class="text-[15px] hover:text-white">
                        About
                    </nuxt-link>
                </li>
            </ul>
        </div>
    </footer>
</template>

<script lang="ts" setup>
const appName: string = useRuntimeConfig().public.appName;
</script>
