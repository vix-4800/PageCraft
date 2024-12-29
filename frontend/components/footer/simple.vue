<template>
    <footer
        class="px-10 py-10 font-sans tracking-wide bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900"
    >
        <div class="max-w-screen-xl mx-auto">
            <div
                class="flex flex-wrap items-center gap-6 md:justify-between max-md:flex-col"
            >
                <div>
                    <nuxt-link to="/">
                        <nuxt-img src="/logo.png" :alt="appName" class="w-16" />
                    </nuxt-link>
                </div>

                <ul
                    class="flex flex-wrap items-center justify-center space-x-6 gap-y-2 md:justify-end"
                >
                    <li>
                        <nuxt-link
                            to="/"
                            class="text-base text-gray-300 hover:underline"
                        >
                            Home
                        </nuxt-link>
                    </li>
                    <li>
                        <nuxt-link
                            to="/about"
                            class="text-base text-gray-300 hover:underline"
                        >
                            About
                        </nuxt-link>
                    </li>
                    <li>
                        <nuxt-link
                            to="/terms"
                            class="text-base text-gray-300 hover:underline"
                        >
                            Terms of Service
                        </nuxt-link>
                    </li>
                    <li>
                        <nuxt-link
                            to="/contact"
                            href="javascript:void(0)"
                            class="text-base text-gray-300 hover:underline"
                        >
                            Contact
                        </nuxt-link>
                    </li>
                </ul>
            </div>

            <hr class="my-6 border-gray-500" />

            <p class="text-base text-center text-gray-300">
                © {{ appName }}. All rights reserved.
            </p>
        </div>
    </footer>
</template>

<script lang="ts" setup>
const appName: string = useRuntimeConfig().public.appName;
</script>
