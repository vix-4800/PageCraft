<template>
    <main>
        <component :is="productListComponent" />
    </main>
</template>

<script lang="ts" setup>
const product_list: string = 'default';
const productListComponent = defineAsyncComponent(
    () => import(`@/components/product-list/${product_list}.vue`)
);
</script>
