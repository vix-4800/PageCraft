<template>
    <div>
        <dashboard-page-name title="My Reviews" />

        <page-in-progress />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'verified'],
});
</script>
