<template>
    <editable-block :block="TemplateBlock.ProductDetail">
        <component
            :is="productDetailComponent"
            :product="product"
            :reviews="reviews"
            :variations="variations"
        />
    </editable-block>
</template>

<script lang="ts" setup>
import type { Product, ProductVariation } from '~/types/product';
import type { Review } from '~/types/review';
import { TemplateBlock } from '~/types/site_template';

const templateStore = useSiteTemplatesStore();

const productDetailComponent = computed(() => {
    const template = templateStore.getTemplate(TemplateBlock.ProductDetail);
    return defineAsyncComponent({
        loader: () => import(`@/components/product-detail/${template}.vue`),
        delay: 200,
        errorComponent: () => import(`@/components/product-detail/default.vue`),
        timeout: 3000,
    });
});

const product = ref<Product | null>(null);
const variations = ref<ProductVariation[]>([]);

const reviews = ref<Review[]>([]);

const route = useRoute();
onMounted(async () => {
    try {
        const { data: productData } = await apiFetch<{ data: Product }>(
            `v1/products/${route.params.slug}`
        );

        product.value = productData;
        variations.value = product.value.variations;

        const { data: reviewsData } = await apiFetch<{ data: Review[] }>(
            `v1/products/${route.params.slug}/reviews`
        );

        reviews.value = reviewsData;
    } catch (error) {
        if (error.status === 404) {
            throw createError({
                statusCode: 404,
                statusMessage: 'Product not found',
                fatal: true,
            });
        }
    }
});
</script>
