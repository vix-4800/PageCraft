<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Create Product</h2>
        </div>
        <div class="p-6">
            <u-form
                class="flex flex-col min-w-full gap-6 space-y-4 overflow-x-auto rounded"
                @submit="submitForm"
            >
                <div class="px-1 space-y-2">
                    <h3 class="text-xl font-bold text-gray-800">Details</h3>

                    <div class="flex w-full gap-2">
                        <u-form-group label="Name" class="w-1/2" name="name">
                            <u-input
                                color="blue"
                                v-model="product.name"
                                required
                            />
                        </u-form-group>

                        <u-form-group label="Slug" class="w-1/2" name="slug">
                            <u-input
                                color="blue"
                                v-model="product.slug"
                                required
                            />
                        </u-form-group>
                    </div>

                    <u-form-group label="Description" name="description">
                        <u-textarea
                            required
                            color="blue"
                            v-model="product.description"
                        />
                    </u-form-group>

                    <u-form-group label="Image" name="image">
                        <u-input
                            color="blue"
                            type="file"
                            v-model="product.image"
                            :ui="{ icon: { trailing: { pointer: '' } } }"
                        >
                            <template #trailing>
                                <u-button
                                    v-show="product.image"
                                    color="gray"
                                    variant="link"
                                    icon="i-heroicons-x-mark-20-solid"
                                    :padded="false"
                                    @click="product.image = null"
                                />
                            </template>
                        </u-input>
                    </u-form-group>
                </div>

                <div class="space-y-3">
                    <h3 class="text-xl font-bold text-gray-800">
                        Variations ({{ product.variations.length }})
                    </h3>

                    <div class="px-1 space-y-2">
                        <u-card
                            class="bg-slate-100"
                            v-for="(variation, index) in product.variations"
                            :key="index"
                        >
                            <template #header>
                                <h3 class="text-lg font-bold">
                                    Variation with sku '{{ variation.sku }}'
                                </h3>
                            </template>

                            <div class="space-y-3">
                                <div class="flex gap-2">
                                    <u-form-group label="Sku" class="w-1/3">
                                        <u-input
                                            color="blue"
                                            v-model="variation.sku"
                                            required
                                        />
                                    </u-form-group>

                                    <u-form-group label="Price" class="w-1/3">
                                        <u-input
                                            color="blue"
                                            v-model="variation.price"
                                            required
                                        />
                                    </u-form-group>

                                    <u-form-group
                                        label="Quantity"
                                        class="w-1/3"
                                    >
                                        <u-input
                                            color="blue"
                                            v-model="variation.stock"
                                            required
                                        />
                                    </u-form-group>
                                </div>

                                <u-form-group label="Image">
                                    <u-input
                                        color="blue"
                                        type="file"
                                        v-model="variation.image"
                                        :ui="{
                                            icon: { trailing: { pointer: '' } },
                                        }"
                                    >
                                        <template #trailing>
                                            <u-button
                                                v-show="variation.image"
                                                color="gray"
                                                variant="link"
                                                icon="i-heroicons-x-mark-20-solid"
                                                :padded="false"
                                                @click="variation.image = null"
                                            />
                                        </template>
                                    </u-input>
                                </u-form-group>

                                <div class="flex flex-col gap-2">
                                    <h3 class="text-lg font-bold">
                                        Attributes ({{
                                            variation.attributes.length
                                        }})
                                    </h3>
                                    <div
                                        class="flex gap-2"
                                        v-for="attribute in variation.attributes"
                                        :key="attribute.name"
                                    >
                                        <u-form-group
                                            label="Name"
                                            class="w-1/2"
                                            name="attribute.name"
                                        >
                                            <u-input
                                                color="blue"
                                                v-model="attribute.name"
                                                required
                                            />
                                        </u-form-group>

                                        <u-form-group
                                            label="Value"
                                            class="w-1/2"
                                            name="attribute.value"
                                        >
                                            <u-input
                                                color="blue"
                                                v-model="attribute.value"
                                                required
                                            />
                                        </u-form-group>

                                        <!-- <u-select
                                            v-model="attribute.name"
                                            color="blue"
                                            size="lg"
                                            class="w-1/2"
                                            :options="attributeNames"
                                            placeholder="Select Attribute"
                                            @change="selectedAttr = attribute"
                                        />

                                        <u-select
                                            v-model="attribute.value"
                                            color="blue"
                                            size="lg"
                                            class="w-1/2"
                                            :options="
                                                availableAttributes[
                                                    selectedAttr.name
                                                ]
                                            "
                                            placeholder="Select Value"
                                        /> -->
                                    </div>

                                    <div class="flex gap-2">
                                        <u-button
                                            color="orange"
                                            size="md"
                                            type="button"
                                            @click="addAttribute(variation)"
                                        >
                                            Add Attribute
                                        </u-button>

                                        <u-button
                                            v-if="
                                                variation.attributes.length > 0
                                            "
                                            color="red"
                                            size="md"
                                            type="button"
                                            @click="removeAttribute(variation)"
                                        >
                                            Remove Attribute
                                        </u-button>
                                    </div>
                                </div>
                            </div>
                        </u-card>
                    </div>

                    <div class="flex gap-2">
                        <u-button
                            color="orange"
                            size="md"
                            type="button"
                            @click="addVariation"
                        >
                            Add Variation
                        </u-button>
                        <u-button
                            v-if="product.variations.length > 0"
                            color="red"
                            size="md"
                            type="button"
                            @click="removeVariation"
                        >
                            Remove Variation
                        </u-button>
                    </div>
                </div>

                <u-button
                    class="w-min"
                    :disabled="product.variations.length === 0"
                    color="blue"
                    size="md"
                    type="submit"
                >
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

const product = reactive({
    name: undefined,
    slug: undefined,
    description: undefined,
    image: undefined,
    variations: [] as ProductVariation[],
});

const { $notify } = useNuxtApp();
async function submitForm() {
    const { data } = await useFetch(`${apiUrl}/v1/products`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${useAuthStore().authToken}`,
        },
        body: JSON.stringify(product),
    });

    if (!data.value) {
        $notify('Something went wrong', 'error');
        return;
    }

    navigateTo(`/dashboard/products`);
    $notify('Product created successfully', 'success');
}

const availableAttributes = ref<ProductVariantAttribute[]>([]);
const attributeNames = ref<string[]>([]);
const selectedAttr = ref<string | null>(null);
onMounted(async () => {
    // const { data } = await $fetch(`${apiUrl}/v1/productAttributes`, {
    //     headers: {
    //         'Content-Type': 'application/json',
    //         Accept: 'application/json',
    //     },
    // });
    // data.forEach((attribute) => {
    //     const [key, values] = Object.entries(attribute)[0];
    //     availableAttributes.value[key] = values;
    // });
    // attributeNames.value = Object.keys(availableAttributes.value);
    // selectedAttr.value = attributeNames.value[0];
});

function addVariation() {
    product.variations.push({
        sku: undefined,
        price: undefined,
        stock: undefined,
        image: undefined,
        attributes: [],
    });
}

function removeVariation() {
    product.variations.pop();
}

function addAttribute(variation: ProductVariation) {
    variation.attributes.push({
        name: undefined,
        value: undefined,
    });
}

function removeAttribute(variation: ProductVariation) {
    variation.attributes.pop();
}
</script>
