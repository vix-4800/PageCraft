<template>
    <div>
        <dashboard-page-name title="FAQ" />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});
</script>
