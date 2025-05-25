<template>
    <div>
        <dashboard-page-name title="Application Statistics" />

        <div class="space-y-4">
            <widget-matomo
                module-to-widgetize="DevicesDetection"
                action-to-widgetize="getType"
                :height="250"
            />

            <widget-matomo
                module-to-widgetize="DevicesDetection"
                action-to-widgetize="getBrowsers"
                :height="215"
            />

            <widget-matomo
                module-to-widgetize="Actions"
                action-to-widgetize="getPageUrls"
                :height="350"
            />

            <widget-matomo
                container-id="EcommerceOverview"
                module-to-widgetize="CoreHome"
                action-to-widgetize="renderWidgetContainer"
                :height="350"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});
</script>
