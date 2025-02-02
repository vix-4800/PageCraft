<template>
    <div class="relative flex w-full rounded-md lg:w-96 md:w-64">
        <u-input
            v-model="search"
            color="white"
            size="lg"
            icon="material-symbols:search"
            :placeholder="$t('search')"
            class="w-full border-0 outline-none ring-0"
            :ui="{
                icon: { trailing: { pointer: '' } },
                color: {
                    white: {
                        outline:
                            'shadow-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-white ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-yellow-400',
                    },
                },
            }"
        >
            <template #trailing>
                <u-button
                    v-show="search !== ''"
                    color="gray"
                    variant="link"
                    icon="i-heroicons-x-mark-20-solid"
                    :padded="false"
                    :loading="searching"
                    @click="search = ''"
                />
            </template>
        </u-input>

        <div
            v-if="search !== ''"
            class="absolute left-0 z-50 flex items-center justify-center w-full p-4 bg-white border border-gray-200 rounded-md shadow-md top-10"
        >
            <ul
                v-if="results['products'].length || results['articles'].length"
                class="w-full h-full overflow-y-auto max-h-96"
            >
                <li v-for="(items, category) in results" :key="category">
                    <div v-if="items.length">
                        <div class="space-y-1">
                            <span class="text-lg font-semibold">
                                {{ capitalize(category) }}
                            </span>
                            <ul class="space-y-2">
                                <li v-for="item in items" :key="item.slug">
                                    <u-button
                                        size="lg"
                                        color="white"
                                        class="w-full border-0 ring-0"
                                        @click="open(item, category)"
                                    >
                                        {{ item.name || item.title }}
                                    </u-button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <u-divider v-if="results[category].length" class="my-4" />
                </li>
            </ul>

            <div
                v-else
                class="flex items-center justify-center w-full h-full text-sm text-gray-500"
            >
                No results found
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';
import type { Article } from '~/types/article';

const search = ref('');
const searching = ref(false);
const results = ref<{ products: Product[]; articles: Article[] }>();

const debounceTimeout = ref<number>();

watch(
    () => search.value,
    () => {
        if (debounceTimeout.value) clearTimeout(debounceTimeout.value);

        debounceTimeout.value = window.setTimeout(async () => {
            if (search.value) {
                searching.value = true;

                const { data } = await apiFetch<{
                    data: { products: Product[]; articles: Article[] };
                }>(`v1/search`, {
                    params: {
                        q: search.value,
                    },
                });

                searching.value = false;
                results.value = data;
            }
        }, 500);
    }
);

const open = (item: Product | Article, category: string) => {
    search.value = '';

    if (category === 'products') {
        navigateTo(`/products/${item.slug}`);
    } else if (category === 'articles') {
        navigateTo(`/articles/${item.slug}`);
    }
};
</script>
