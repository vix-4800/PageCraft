<template>
    <div class="flex flex-col items-center justify-center h-screen gap-6">
        <nuxt-img
            src="/logo.png"
            :alt="appName"
            class="animate-glowing-pulse"
        />
        <span
            style="font-family: 'Merriweather'; font-weight: 700"
            class="text-4xl text-white"
        >
            {{ appName }}
        </span>

        <div class="mt-4 text-lg text-center text-gray-400">
            <span class="block">Your website is ready!</span>
            <span class="block">
                Navigate to
                <nuxt-link
                    class="text-gray-100 hover:underline hover:text-gray-300"
                    to="/dashboard"
                >
                    <code class="mx-1">/dashboard</code>
                </nuxt-link>
                to get started.
            </span>
        </div>

        <div
            class="absolute text-gray-500 bottom-4 hover:text-gray-400 hover:underline"
        >
            <a
                href="https://github.com/vix-4800/PageCraft"
                class="flex items-center gap-2"
                target="_blank"
            >
                <Icon name="uil:github" style="color: white" />
                GitHub
            </a>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'empty',
});

const appName: string = useRuntimeConfig().public.appName;
</script>
