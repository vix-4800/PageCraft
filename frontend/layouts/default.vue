<template>
    <div class="page-transition layout-transition">
        <component :is="headerComponent" />

        <slot></slot>

        <component :is="footerComponent" />
    </div>
</template>

<script lang="ts" setup>
import { defineAsyncComponent } from 'vue';

const pageStore = usePageConfigurationStore();

const header = ref(pageStore.header);
const footer = ref(pageStore.footer);

onMounted(async () => {
    await pageStore.getConfig();

    header.value = pageStore.header;
    footer.value = pageStore.footer;
});

const headerComponent = computed(() =>
    defineAsyncComponent(
        () => import(`@/components/header/${header.value}.vue`)
    )
);
const footerComponent = computed(() =>
    defineAsyncComponent(
        () => import(`@/components/footer/${footer.value}.vue`)
    )
);
</script>
