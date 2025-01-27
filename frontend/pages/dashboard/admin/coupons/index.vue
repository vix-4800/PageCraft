<template>
    <div>
        <dashboard-page-name title="Coupons" />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});
</script>
