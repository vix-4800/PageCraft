<template>
    <div
        class="w-full h-screen bg-gray-900 flex items-center justify-center flex-col gap-6"
    >
        <img src="@img/logo.png" alt="" class="animate-glowing-pulse" />
        <span
            style="font-family: 'Merriweather'; font-weight: 700"
            class="text-4xl text-white"
        >
            {{ appName }}
        </span>

        <div class="text-gray-400 text-center mt-4 text-lg">
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
            class="absolute bottom-4 text-gray-500 hover:text-gray-400 hover:underline"
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
const config = useRuntimeConfig();
const appName = config.public.appName;
</script>
