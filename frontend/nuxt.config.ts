import { fileURLToPath } from 'url';

export default defineNuxtConfig({
    compatibilityDate: '2024-04-03',
    devtools: { enabled: true },
    modules: [
        '@nuxt/eslint',
        '@vueuse/nuxt',
        '@nuxtjs/color-mode',
        '@formkit/auto-animate',
        '@nuxt/image',
        '@nuxt/icon',
        '@nuxt/fonts',
        '@nuxtjs/google-fonts',
        '@pinia/nuxt',
        '@nuxt/ui',
        'nuxt-echarts',
        'pinia-plugin-persistedstate/nuxt',
    ],
    plugins: [{ src: '~/plugins/notify', mode: 'client' }],
    app: {
        head: {
            title: process.env.APP_NAME || 'PageCraft',
            meta: [
                {
                    name: 'viewport',
                    content: 'width=device-width, initial-scale=1',
                },
            ],
        },
        // pageTransition: { name: 'page', mode: 'out-in' },
        layoutTransition: { name: 'layout', mode: 'out-in' },
    },
    alias: {
        '@': fileURLToPath(new URL('./', import.meta.url)),
        '@img': fileURLToPath(new URL('./assets/img', import.meta.url)),
        '@css': fileURLToPath(new URL('./assets/css', import.meta.url)),
    },
    css: ['@css/app.css', 'notyf/notyf.min.css'],
    colorMode: {
        preference: 'system',
        fallback: 'dark',
        storage: 'localStorage',
    },
    runtimeConfig: {
        public: {
            baseUrl: process.env.APP_URL || 'http://localhost:80',
            appName: process.env.APP_NAME || 'PageCraft',
            apiBaseUrl: process.env.API_BASE_URL || 'http://localhost:8080',
            apiUrl: process.env.API_URL || 'http://localhost:8080' + '/api',
        },
    },
    googleFonts: {
        families: {
            Merriweather: {
                wght: [400, 700],
            },
        },
    },
    echarts: {
        ssr: true,
        renderer: ['canvas'],
        charts: ['PieChart', 'LineChart'],
        components: [
            'TitleComponent',
            'DatasetComponent',
            'GridComponent',
            'TooltipComponent',
            'ToolboxComponent',
            'GeoComponent',
            'VisualMapComponent',
            'LegendComponent',
        ],
    },
});
