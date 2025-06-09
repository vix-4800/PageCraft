<template>
    <div>
        <dashboard-page-name title="FAQ" />

        <page-in-progress />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});
</script>
