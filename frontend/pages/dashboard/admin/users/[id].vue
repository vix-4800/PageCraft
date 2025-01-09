<template>
    <div></div>
</template>

<script lang="ts" setup>
import type { User } from '~/types/user';

definePageMeta({
    layout: 'dashboard',
    middleware: ['dashboard', 'verified'],
});
</script>
