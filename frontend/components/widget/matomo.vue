<template>
    <div>
        <div v-if="loading" class="p-4 text-gray-500">Loading analytics...</div>

        <div
            v-else-if="!isMatomoAvailable"
            class="h-[250px] flex items-center justify-center bg-gray-50 mb-4 dark:bg-gray-800 rounded-lg"
        >
            <div class="text-center text-gray-500 dark:text-gray-400">
                <svg
                    class="w-12 h-12 mx-auto mb-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <p class="font-medium">Analytics service is unavailable</p>
                <p class="mt-1 text-sm">Please check Matomo configuration</p>
            </div>
        </div>

        <iframe
            v-else
            width="100%"
            :height="height"
            :src="url.toString()"
            scrolling="yes"
            frameborder="0"
            marginheight="0"
            marginwidth="0"
            loading="lazy"
        ></iframe>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps({
    moduleToWidgetize: {
        type: String,
        required: true,
    },
    actionToWidgetize: {
        type: String,
        required: true,
    },
    containerId: {
        type: String,
        default: '',
    },
    height: {
        type: Number,
        default: 250,
    },
});

const url = new URL('http://localhost:8082/index.php');
url.searchParams.set('module', 'Widgetize');
url.searchParams.set('action', 'iframe');
url.searchParams.set('disableLink', '1');
url.searchParams.set('widget', '1');
url.searchParams.set('moduleToWidgetize', props.moduleToWidgetize);
url.searchParams.set('actionToWidgetize', props.actionToWidgetize);
url.searchParams.set('idSite', '1');
url.searchParams.set('period', 'day');
url.searchParams.set('date', 'yesterday');

if (props.containerId) {
    url.searchParams.set('containerId', props.containerId);
}

const loading = ref(true);
const isMatomoAvailable = ref(false);

onMounted(async () => {
    try {
        const response = await fetch('http://localhost:8082/status');
        isMatomoAvailable.value = response.ok;
    } catch (error) {
        console.error(error);
        isMatomoAvailable.value = false;
    } finally {
        loading.value = false;
    }
});
</script>
