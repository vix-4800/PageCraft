<template>
    <div>
        <DashboardPageName title="Marketplace Accounts" />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});
</script>
