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

    <u-divider
        label="OR"
        :ui="{
            border: { base: 'border-gray-500' },
            label: 'text-gray-500',
            container: { horizontal: 'my-4' },
        }"
    />

    <u-button
        class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
        size="lg"
        block
        label="Login"
        to="/login"
    />
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'auth',
});
</script>
