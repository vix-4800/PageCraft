<template>
    <header class="shadow-md font-[sans-serif] tracking-wide relative z-50">
        <section
            class="md:flex lg:items-center relative py-3 lg:px-10 px-4 bg-gradient-to-br from-gray-900 to-gray-700 lg:min-h-[80px] max-lg:min-h-[60px]"
        >
            <nuxt-link
                to="/"
                class="flex items-center gap-4 max-sm:w-full max-sm:mb-3 shrink-0"
            >
                <nuxt-img
                    src="/logo.png"
                    :alt="appName"
                    width="40px"
                    height="40px"
                />
                <span class="text-2xl font-bold text-white">
                    {{ appName }}
                </span>
            </nuxt-link>

            <div class="flex flex-wrap items-center w-full">
                <input
                    type="text"
                    placeholder="Search something..."
                    class="xl:w-96 max-lg:w-full lg:ml-10 max-md:mt-4 max-lg:ml-4 bg-gray-100 border-2 border-gray-300 bg-transparent focus:ring-0 text-gray-200 px-6 rounded h-11 outline-[#333] text-sm transition-all"
                />
                <div class="ml-auto max-lg:mt-4">
                    <ul class="flex items-center">
                        <li class="px-3 cursor-pointer max-lg:py-2">
                            <nuxt-link to="/cart">
                                <span class="relative">
                                    <u-icon
                                        name="material-symbols:shopping-cart-outline"
                                        size="23"
                                        class="text-gray-200"
                                    />
                                    <span
                                        class="absolute left-auto px-1 py-0 -ml-1 text-xs text-gray-900 bg-yellow-500 rounded-full -top-3"
                                    >
                                        {{ cartCount }}
                                    </span>
                                </span>
                            </nuxt-link>
                        </li>
                        <li
                            class="flex text-[15px] max-lg:py-2 px-3 hover:text-yellow-500 hover:fill-yellow-500"
                        >
                            <button
                                v-if="!isAuthenticated"
                                class="px-4 py-2 text-sm font-semibold text-white bg-transparent border-2 border-yellow-500 rounded hover:bg-yellow-500 hover:text-gray-900"
                                @click="login"
                            >
                                Sign In
                            </button>

                            <button
                                v-else
                                class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-transparent border-2 border-yellow-500 rounded hover:bg-yellow-500 hover:text-gray-900"
                                @click="dashboard"
                            >
                                <u-icon
                                    name="material-symbols:account-circle"
                                    size="20"
                                />
                                Dashboard
                            </button>
                        </li>
                        <li class="lg:hidden" @click="toggleMenu">
                            <button>
                                <svg
                                    class="w-7 h-7"
                                    fill="#333"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
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
            <button
                class="lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white p-3"
                @click="toggleMenu"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 fill-black"
                    viewBox="0 0 320.591 320.591"
                >
                    <path
                        d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                        data-original="#000000"
                    />
                    <path
                        d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                        data-original="#000000"
                    />
                </svg>
            </button>

            <ul
                class="lg:flex lg:flex-wrap lg:items-center lg:justify-center px-10 py-3 bg-gradient-to-br from-gray-900 to-gray-700 min-h-[46px] gap-4 max-lg:space-y-4 max-lg:fixed max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50"
            >
                <li class="hidden mb-6 max-lg:block">
                    <nuxt-link
                        to="/"
                        class="flex items-center gap-4 max-sm:w-full max-sm:mb-3 shrink-0"
                    >
                        <nuxt-img
                            src="/logo.png"
                            :alt="appName"
                            width="40px"
                            height="40px"
                        />
                        <span class="text-2xl font-bold text-white">
                            {{ appName }}
                        </span>
                    </nuxt-link>
                </li>
                <li
                    v-for="category in categories"
                    :key="category.name"
                    class="px-3 max-lg:border-b max-lg:py-3"
                >
                    <nuxt-link
                        :to="category.href"
                        class="hover:text-yellow-300 text-white text-[15px] font-medium block"
                    >
                        {{ category.name }}
                    </nuxt-link>
                </li>
            </ul>
        </div>
    </header>
</template>

<script lang="ts" setup>
const appName: string = useRuntimeConfig().public.appName;

const authStore = useAuthStore();
const isAuthenticated: boolean = authStore.authenticated;

const login = () => {
    navigateTo('/login');
};

const dashboard = () => {
    navigateTo('/dashboard');
};

const isCollapseMenuVisible = ref(false);
const toggleMenu = () => {
    isCollapseMenuVisible.value = !isCollapseMenuVisible.value;
};

const categories = ref([
    { name: 'Home', href: '/' },
    { name: 'Trending', href: '/trending' },
]);

const cartStore = useCartStore();
const cartCount = computed(() => cartStore.totalItems);
</script>

<style scoped>
.router-link-exact-active {
    @apply text-yellow-300;
}
</style>
