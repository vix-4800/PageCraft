<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Product '{{ product.name }}'</h2>
        </div>
        <div class="p-6">
            <u-form
                @submit="submitForm"
                class="flex flex-col min-w-full gap-6 space-y-4 overflow-x-auto rounded"
            >
                <div class="px-1 space-y-2">
                    <h3 class="text-xl font-bold text-gray-800">Details</h3>

                    <div class="flex w-full gap-2">
                        <u-form-group label="Name" class="w-1/2" name="name">
                            <u-input color="blue" v-model="product.name" />
                        </u-form-group>

                        <u-form-group label="Slug" class="w-1/2" name="slug">
                            <u-input color="blue" v-model="product.slug" />
                        </u-form-group>
                    </div>

                    <u-form-group label="Description" name="description">
                        <u-textarea
                            color="blue"
                            v-model="product.description"
                        />
                    </u-form-group>
                </div>

                <nuxt-img
                    :src="product.image"
                    :alt="product.name"
                    class="object-contain w-full h-96"
                />

                <div>
                    <h3 class="text-xl font-bold text-gray-800">Variations</h3>

                    <u-button
                        class="w-min"
                        color="orange"
                        size="md"
                        type="button"
                    >
                        Add
                    </u-button>
                </div>

                <u-button class="w-min" color="blue" size="md" type="submit">
                    Submit
                </u-button>
            </u-form>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
});

const apiUrl: string = useRuntimeConfig().public.apiUrl;

const product = ref<Product>({});
const variations = ref<ProductVariant[]>([]);

onMounted(async () => {
    const response: { data: Product } = await $fetch<{ data: Product[] }>(
        `${apiUrl}/v1/products/${useRoute().params.slug}`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
        }
    );

    product.value = response.data;
    variations.value = product.value.variations;
});

const submitForm = async () => {
    const response: { data: Product } = await $fetch<{ data: Product[] }>(
        `${apiUrl}/v1/products/${useRoute().params.slug}`,
        {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            body: product.value,
        }
    );
};
</script>
