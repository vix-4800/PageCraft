<template>
    <main>
        <component :is="productListComponent" />
    </main>
</template>

<script lang="ts" setup>
import { defineAsyncComponent } from 'vue';

const product_list: string = 'default';
const productListComponent = computed(() =>
    defineAsyncComponent(
        () => import(`@/components/product-list/${product_list}.vue`)
    )
);
</script>
