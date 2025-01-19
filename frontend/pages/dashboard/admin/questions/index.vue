<template>
    <div>
        <DashboardPageName title="User Questions" />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});
</script>
