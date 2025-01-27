<template>
    <div>
        <dashboard-page-name title="New Article" />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});
</script>
