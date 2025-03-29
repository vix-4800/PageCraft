<template>
    <div>
        <dashboard-page-name title="Terminal" />

        <iframe
            class="w-full border border-gray-300 rounded-lg h-[600px]"
            src="http://localhost:7681"
        ></iframe>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});
</script>
