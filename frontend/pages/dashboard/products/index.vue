<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Products</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full overflow-x-auto rounded">
                <div class="w-full px-1">
                    <u-button
                        v-if="!createFormVisible"
                        color="primary"
                        block
                        type="button"
                        @click="toggleCreateForm"
                    >
                        Add Product
                    </u-button>

                    <div v-else>
                        <UForm
                            :state="state"
                            class="space-y-4"
                            @submit="submitCreateForm"
                        >
                            <div class="flex gap-2">
                                <UFormGroup
                                    label="Name"
                                    name="name"
                                    class="w-1/2"
                                >
                                    <UInput
                                        v-model="state.name"
                                        placeholder="Name"
                                    />
                                </UFormGroup>
                                <UFormGroup
                                    label="Slug"
                                    name="slug"
                                    class="w-1/2"
                                >
                                    <UInput
                                        v-model="state.slug"
                                        placeholder="Slug"
                                    />
                                </UFormGroup>
                            </div>

                            <UFormGroup label="Description" name="description">
                                <UInput
                                    v-model="state.description"
                                    placeholder="Description"
                                />
                            </UFormGroup>

                            <div class="flex gap-2">
                                <UButton type="submit">Submit</UButton>
                                <UButton
                                    type="button"
                                    color="red"
                                    @click="toggleCreateForm"
                                >
                                    Cancel
                                </UButton>
                            </div>
                        </UForm>
                    </div>
                </div>

                <hr class="my-4 border-gray-300" />

                <u-table
                    :columns="columns"
                    :rows="products"
                    :loading="status === 'pending' || status === 'idle'"
                    :loading-state="{
                        icon: 'i-heroicons-arrow-path-20-solid',
                        label: 'Loading...',
                    }"
                    :progress="{ color: 'primary', animation: 'carousel' }"
                    class="w-full"
                    @select="select"
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';

definePageMeta({
    layout: 'dashboard',
});

const columns = [
    {
        key: 'name',
        label: 'Name',
        sortable: true,
    },
    {
        key: 'slug',
        label: 'Slug',
    },
    {
        key: 'description',
        label: 'Description',
    },
];

const apiUrl: string = useRuntimeConfig().public.apiUrl;

const products = ref<Product[]>([]);
const status = ref('idle');
onMounted(async () => {
    await getProducts();
});

async function getProducts() {
    const response: { data: Product[] } = await $fetch<{ data: Product[] }>(
        `${apiUrl}/v1/products`,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            onRequest() {
                status.value = 'pending';
            },
            onResponse() {
                status.value = 'success';
            },
        }
    );

    products.value = response.data;
    products.value.forEach((product) => {
        product.description =
            product.description.length > 75
                ? `${product.description.slice(0, 75)}...`
                : product.description;
    });
}

function select(row: Product) {
    return navigateTo('/dashboard/products/' + row.slug);
}

const createFormVisible = ref(false);

function toggleCreateForm() {
    createFormVisible.value = !createFormVisible.value;
}

const state = reactive({
    name: undefined,
    slug: undefined,
    description: undefined,
});

const { $notify } = useNuxtApp();
async function submitCreateForm() {
    const apiUrl: string = useRuntimeConfig().public.apiUrl;

    await useFetch(`${apiUrl}/v1/products`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
        },
        body: {
            name: state.name,
            slug: state.slug,
            description: state.description,
        },
    }).then(async (result) => {
        if (result.error) {
            $notify('Something went wrong', 'error');
            return;
        }

        await getProducts();

        state.name = undefined;
        state.slug = undefined;
        state.description = undefined;
        createFormVisible.value = false;

        $notify('Product created successfully', 'success');
    });
}
</script>
