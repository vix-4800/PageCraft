<template>
    <div class="flex justify-center mb-4">
        <nuxt-link
            to="/"
            class="w-24 transition duration-200 opacity-50 hover:opacity-100 max-h-24"
        >
            <nuxt-img
                src="/logo.png"
                :alt="useRuntimeConfig().public.appName"
            />
        </nuxt-link>
    </div>
</template>
