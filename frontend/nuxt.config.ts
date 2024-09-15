import { fileURLToPath } from 'url';

export default defineNuxtConfig({
    compatibilityDate: '2024-04-03',
    devtools: { enabled: true },
    modules: [
        '@nuxt/eslint',
        '@nuxtjs/tailwindcss',
        '@vueuse/nuxt',
        '@nuxtjs/color-mode',
    ],
    app: {
        head: {
            title: 'PageCraft',
            meta: [
                {
                    name: 'viewport',
                    content: 'width=device-width, initial-scale=1',
                },
            ],
        },
        pageTransition: { name: 'page', mode: 'out-in' },
    },
    alias: {
        '@': fileURLToPath(new URL('./', import.meta.url)),
    },
    css: ['@/assets/css/app.css'],
    colorMode: {
        preference: 'system',
        fallback: 'dark',
        storage: 'localStorage',
    },
});
