<template>
    <header class="shadow-md font-[sans-serif] tracking-wide relative z-50">
        <section
            class="md:flex lg:items-center relative py-3 lg:px-10 px-4 bg-gradient-to-br from-gray-900 to-gray-700 lg:min-h-[80px] max-lg:min-h-[60px]"
        >
            <nuxt-link
                to="/"
                class="flex items-center gap-4 max-sm:w-full max-sm:mb-3 shrink-0 group"
            >
                <nuxt-img
                    src="/logo.png"
                    :alt="appName"
                    width="40px"
                    height="40px"
                />
                <span
                    class="text-2xl font-bold text-white group-hover:text-yellow-500"
                >
                    {{ appName }}
                </span>
            </nuxt-link>

            <div class="flex flex-wrap items-center w-full">
                <u-input-menu
                    v-model="selected"
                    placeholder="Search"
                    size="md"
                    color="yellow"
                    option-attribute="name"
                    class="bg-white rounded-md lg:w-96 max-md:w-full lg:ml-10 max-md:mt-4 max-lg:ml-4"
                    :loading="loadingSearch"
                    :search="onSearchChange"
                    trailing
                    :debounce="700"
                    :search-lazy="true"
                />

                <div class="ml-auto max-lg:mt-4">
                    <ul class="flex items-center space-x-6">
                        <li class="cursor-pointer max-lg:py-2">
                            <nuxt-link to="/products/favorites" class="group">
                                <span class="relative">
                                    <u-icon
                                        name="material-symbols:favorite-outline"
                                        size="23"
                                        class="text-gray-200 group-hover:bg-yellow-500"
                                    />
                                    <span
                                        class="absolute left-auto px-1 py-0 -ml-1 text-xs text-gray-900 bg-yellow-500 rounded-full -top-3"
                                    >
                                        {{ useFavoriteStore().totalItemsCount }}
                                    </span>
                                </span>
                            </nuxt-link>
                        </li>

                        <li class="cursor-pointer max-lg:py-2">
                            <nuxt-link to="/cart" class="group">
                                <span class="relative">
                                    <u-icon
                                        name="material-symbols:shopping-cart-outline"
                                        size="23"
                                        class="text-gray-200 group-hover:bg-yellow-500"
                                    />
                                    <span
                                        class="absolute left-auto px-1 py-0 -ml-1 text-xs text-gray-900 bg-yellow-500 rounded-full -top-3"
                                    >
                                        {{ useCartStore().totalItems }}
                                    </span>
                                </span>
                            </nuxt-link>
                        </li>

                        <li class="max-lg:py-2">
                            <u-button
                                v-if="authStore.isAuthenticated"
                                :to="`/dashboard/${
                                    authStore.isAdmin ? 'admin' : 'user'
                                }`"
                                size="md"
                                class="font-semibold bg-transparent hover:bg-yellow-500 hover:text-gray-900"
                                icon="material-symbols:account-circle"
                                label="Dashboard"
                            />

                            <u-button
                                v-else
                                to="/login"
                                label="Sign In"
                                size="md"
                                class="font-semibold bg-transparent hover:bg-yellow-500 hover:text-gray-900"
                            />
                        </li>

                        <li class="lg:hidden">
                            <u-button
                                icon="material-symbols:menu"
                                class="bg-transparent hover:bg-yellow-500 hover:text-gray-900"
                                size="md"
                                @click="toggleMenu"
                            />
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <div
            v-show="isCollapseMenuVisible"
            :class="{ isCollapseMenuVisible: 'max-lg:hidden' }"
            class="lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-50 max-lg:before:inset-0 max-lg:before:z-50"
        >
            <u-button
                class="lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white p-3 text-gray-800 hover:bg-yellow-500 hover:text-gray-900"
                icon="material-symbols:close"
                @click="toggleMenu"
            />

            <ul
                class="lg:flex lg:flex-wrap lg:items-center lg:justify-center px-10 py-3 bg-gradient-to-br from-gray-900 to-gray-700 min-h-[46px] gap-4 max-lg:space-y-4 max-lg:fixed max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50"
            >
                <li class="hidden mb-6 max-lg:block">
                    <nuxt-link
                        to="/"
                        class="flex items-center gap-4 max-sm:w-full group max-sm:mb-3 shrink-0"
                    >
                        <nuxt-img
                            src="/logo.png"
                            :alt="appName"
                            width="40px"
                            height="40px"
                        />
                        <span
                            class="text-2xl font-bold text-white group-hover:text-yellow-500"
                        >
                            {{ appName }}
                        </span>
                    </nuxt-link>
                </li>
                <li
                    v-for="page in headerPages"
                    :key="page.name"
                    class="px-3 max-lg:border-b max-lg:py-3"
                >
                    <u-link
                        :to="page.href"
                        class="flex items-center gap-1 text-sm hover:text-yellow-500"
                        active-class="text-yellow-400"
                        inactive-class="text-white"
                    >
                        <u-icon
                            :name="page.icon"
                            class="inline-block w-5 h-5"
                        />
                        {{ page.name }}
                    </u-link>
                </li>
            </ul>
        </div>
    </header>
</template>

<script lang="ts" setup>
import type { Product } from '~/types/product';

defineProps({
    headerPages: {
        type: Array as () => {
            name: string;
            href: string;
            icon: string;
        }[],
        required: true,
    },
});

const authStore = useAuthStore();
const appName: string = useRuntimeConfig().public.appName;

const isCollapseMenuVisible = ref(false);
const toggleMenu = () => {
    isCollapseMenuVisible.value = !isCollapseMenuVisible.value;
};

const selected = ref();
const loadingSearch = ref(false);
async function onSearchChange(q: string) {
    if (q) {
        loadingSearch.value = true;

        const { data } = await apiFetch<{ data: Product[] }>(
            `v1/products/search`,
            {
                params: {
                    q,
                },
            }
        );

        loadingSearch.value = false;
        return data;
    }
}

watch(selected, () => {
    if (selected.value) {
        navigateTo(`/products/${selected.value.slug}`);

        selected.value = undefined;
    }
});
</script>
