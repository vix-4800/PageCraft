<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Page Configuration</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full overflow-x-auto rounded">
                <form class="flex flex-col gap-2 px-1">
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label
                                for="header-styles"
                                class="block w-full text-sm font-medium text-gray-600"
                            >
                                Header
                            </label>
                            <u-select
                                id="header-styles"
                                v-model="headerStylesSelect"
                                color="blue"
                                :options="headerStylesOptions"
                                size="lg"
                            />
                        </div>
                        <div class="w-1/2">
                            <label
                                for="footer-styles"
                                class="block w-full text-sm font-medium text-gray-600"
                            >
                                Footer
                            </label>
                            <u-select
                                id="footer-styles"
                                v-model="footerStylesSelect"
                                color="blue"
                                :options="footerStylesOptions"
                                size="lg"
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            for="product-list-styles"
                            class="block w-full text-sm font-medium text-gray-600"
                        >
                            Product List
                        </label>
                        <u-select
                            id="product-list-styles"
                            v-model="productListStylesSelect"
                            color="blue"
                            :options="productListStylesOptions"
                            size="lg"
                        />
                    </div>

                    <u-button
                        icon="material-symbols:save"
                        type="submit"
                        size="md"
                        color="blue"
                        class="mt-2 w-min"
                        label="Save"
                        :loading="loading"
                        :disabled="loading"
                        @click="saveConfiguration"
                    />
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'admin'],
});

const pageStore = usePageConfigurationStore();

const headerStylesSelect = ref(pageStore.header);
const productListStylesSelect = ref(pageStore.product_list);
const footerStylesSelect = ref(pageStore.footer);

const headerStylesOptions = [
    { value: 'default', label: 'Default' },
    { value: 'minimalistic', label: 'Minimalistic' },
];

const productListStylesOptions = [
    { value: 'default', label: 'Default' },
    { value: 'minimalistic', label: 'Minimalistic' },
];

const footerStylesOptions = [
    { value: 'default', label: 'Default' },
    { value: 'minimalistic', label: 'Minimalistic' },
];

const loading = ref(false);
onMounted(async () => {
    loading.value = true;
    await pageStore.getConfig();

    headerStylesSelect.value = pageStore.header;
    productListStylesSelect.value = pageStore.product_list;
    footerStylesSelect.value = pageStore.footer;
    loading.value = false;
});

const { $notify } = useNuxtApp();
const saveConfiguration = async (e: { preventDefault: () => void }) => {
    e.preventDefault();

    loading.value = true;
    await pageStore.saveConfiguration({
        header: headerStylesSelect.value,
        product_list: productListStylesSelect.value,
        footer: footerStylesSelect.value,
    });

    loading.value = false;
    $notify('Configuration saved successfully', 'success');
};
</script>
