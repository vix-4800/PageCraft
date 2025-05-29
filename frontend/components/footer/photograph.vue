<template></template>

<script lang="ts" setup>
const appName: string = useRuntimeConfig().public.appName;

defineProps({
    footerPages: {
        type: Array as () => {
            name: string;
            href: string;
        }[],
        required: true,
    },
    footerContacts: {
        type: Object as () => {
            email: string;
            phone: string;
            address: string;
        },
        required: true,
    },
});
</script>
