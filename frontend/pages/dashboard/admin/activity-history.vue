<template>
    <div>
        <dashboard-page-name title="Activity History" />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});
</script>
