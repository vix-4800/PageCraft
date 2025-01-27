<template>
    <div>
        <dashboard-page-name title="Application Statistics" />

        <div class="space-y-4">
            <div>
                <iframe
                    width="100%"
                    height="260"
                    src="http://localhost:8082/index.php?module=Widgetize&action=iframe&disableLink=1&widget=1&moduleToWidgetize=DevicesDetection&actionToWidgetize=getType&idSite=1&period=day&date=yesterday"
                    scrolling="yes"
                    frameborder="0"
                    marginheight="0"
                    marginwidth="0"
                ></iframe>
            </div>

            <div>
                <iframe
                    width="100%"
                    height="215"
                    src="http://localhost:8082/index.php?module=Widgetize&action=iframe&disableLink=1&widget=1&moduleToWidgetize=DevicesDetection&actionToWidgetize=getBrowsers&idSite=1&period=day&date=yesterday"
                    scrolling="yes"
                    frameborder="0"
                    marginheight="0"
                    marginwidth="0"
                ></iframe>
            </div>

            <div>
                <iframe
                    width="100%"
                    height="350"
                    src="http://localhost:8082/index.php?module=Widgetize&action=iframe&disableLink=1&widget=1&moduleToWidgetize=Actions&actionToWidgetize=getPageUrls&idSite=1&period=day&date=yesterday"
                    scrolling="yes"
                    frameborder="0"
                    marginheight="0"
                    marginwidth="0"
                ></iframe>
            </div>

            <div>
                <iframe
                    width="100%"
                    height="350"
                    src="http://localhost:8082/index.php?module=Widgetize&action=iframe&containerId=EcommerceOverview&disableLink=1&widget=1&moduleToWidgetize=CoreHome&actionToWidgetize=renderWidgetContainer&idSite=1&period=day&date=yesterday"
                    scrolling="yes"
                    frameborder="0"
                    marginheight="0"
                    marginwidth="0"
                ></iframe>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});
</script>
