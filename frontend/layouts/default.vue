<template>
    <div class="page-transition layout-transition">
        <component :is="headerComponent" />

        <slot></slot>

        <component :is="footerComponent" />
    </div>
</template>

<script lang="ts" setup>
import { defineAsyncComponent } from 'vue';
const header: string = 'default';
const footer: string = 'default';

const headerComponent = computed(() =>
    defineAsyncComponent(() => import(`@/components/header/${header}.vue`))
);

const footerComponent = computed(() =>
    defineAsyncComponent(() => import(`@/components/footer/${footer}.vue`))
);
</script>
