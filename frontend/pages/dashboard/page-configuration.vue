<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Page Configuration</h2>
            <h3 class="text-sm font-medium text-slate-500">
                Select page block templates
            </h3>
        </div>
        <div class="p-6">
            <div class="min-w-full overflow-x-auto rounded">
                <form class="space-y-4">
                    <div>
                        <label
                            for="header-styles"
                            class="block w-full text-sm font-medium text-gray-600"
                        >
                            Header
                        </label>
                        <select
                            id="header-styles"
                            v-model="headerStylesSelect"
                            class="block w-full h-10 px-2 py-1 text-base text-gray-600 border border-gray-300 rounded-lg focus:outline-none"
                        >
                            <option
                                v-for="option in headerStylesOptions"
                                :key="option.value"
                                :value="option.value"
                            >
                                {{ option.label }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            for="product-list-styles"
                            class="block w-full text-sm font-medium text-gray-600"
                        >
                            Product List
                        </label>
                        <select
                            id="product-list-styles"
                            v-model="productListStylesSelect"
                            class="block w-full h-10 px-2 py-1 text-base text-gray-600 border border-gray-300 rounded-lg focus:outline-none"
                        >
                            <option
                                v-for="option in productListStylesOptions"
                                :key="option.value"
                                :value="option.value"
                            >
                                {{ option.label }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            for="footer-styles"
                            class="block w-full text-sm font-medium text-gray-600"
                        >
                            Footer
                        </label>
                        <select
                            id="footer-styles"
                            v-model="footerStylesSelect"
                            class="block w-full h-10 px-2 py-1 text-base text-gray-600 border border-gray-300 rounded-lg focus:outline-none"
                        >
                            <option
                                v-for="option in footerStylesOptions"
                                :key="option.value"
                                :value="option.value"
                            >
                                {{ option.label }}
                            </option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="h-10 px-2 py-1 border rounded-lg border-emerald-200 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 hover:text-emerald-800"
                        @click="saveConfiguration"
                    >
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
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

onMounted(async () => {
    await pageStore.getConfig();

    headerStylesSelect.value = pageStore.header;
    productListStylesSelect.value = pageStore.product_list;
    footerStylesSelect.value = pageStore.footer;
});

const saveConfiguration = (e: { preventDefault: () => void }) => {
    e.preventDefault();

    pageStore.saveConfiguration({
        header: headerStylesSelect.value,
        product_list: productListStylesSelect.value,
        footer: footerStylesSelect.value,
    });
};
</script>
