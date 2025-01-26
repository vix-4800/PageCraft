<template>
    <div>
        <dashboard-page-name title="My Reviews" />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['verified'],
});
</script>
