<template>
    <header
        class="flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50"
    >
        <div class="flex flex-wrap items-center justify-between w-full gap-5">
            <nuxt-link to="/" class="items-center hidden gap-4 sm:flex group">
                <nuxt-img
                    src="/logo.png"
                    :alt="appName"
                    width="40px"
                    height="40px"
                    class="bg-blue-500 rounded-full"
                />
                <span
                    class="text-2xl font-bold text-blue-500 group-hover:text-blue-600"
                >
                    {{ appName }}
                </span>
            </nuxt-link>
            <nuxt-link to="/" class="hidden max-sm:block">
                <nuxt-img
                    src="/logo.png"
                    :alt="appName"
                    width="40px"
                    height="40px"
                    class="bg-blue-500 rounded-full"
                />
            </nuxt-link>

            <div
                :class="{
                    isCollapseMenuVisible:
                        'max-lg:hidden lg:!block max-lg:before:bg-black max-lg:before:z-50 max-lg:before:inset-0 max-lg:before:fixed max-lg:before:opacity-50',
                }"
            >
                <ul
                    class="max-lg:p-6 hidden max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50 gap-x-5 max-lg:left-0 max-lg:top-0 max-lg:space-y-3 max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] lg:flex"
                >
                    <li class="hidden mb-6 max-lg:block">
                        <nuxt-link to="/">
                            <nuxt-img
                                src="/logo.png"
                                :alt="appName"
                                width="40px"
                                height="40px"
                                class="bg-blue-500 rounded-full"
                            />
                        </nuxt-link>
                    </li>
                    <li
                        v-for="category in pages"
                        :key="category.name"
                        class="px-3 border-gray-300 max-lg:border-b max-lg:py-3"
                    >
                        <u-link
                            :to="category.href"
                            class="block font-semibold text-[15px]"
                            active-class="text-blue-500"
                            inactive-class="text-gray-500 hover:text-blue-500"
                        >
                            {{ category.name }}
                        </u-link>
                    </li>
                </ul>
            </div>

            <div class="flex space-x-4 max-lg:ml-auto">
                <div v-if="!authStore.isAuthenticated" class="flex gap-2">
                    <u-button
                        to="/login"
                        label="Login"
                        class="px-4 py-2 text-sm font-bold text-gray-500 transition-all duration-300 ease-in-out bg-transparent border-2 rounded-full hover:bg-gray-50"
                    />
                    <u-button
                        to="/register"
                        label="Sign up"
                        class="px-4 py-2 text-sm font-bold text-white transition-all duration-300 ease-in-out bg-blue-500 border-2 border-blue-500 rounded-full hover:bg-transparent hover:text-blue-500"
                    />
                </div>
                <div v-else>
                    <u-button
                        :to="`/dashboard/${
                            authStore.isAdmin ? 'admin' : 'user'
                        }`"
                        label="Dashboard"
                        class="px-4 py-2 text-sm font-bold text-gray-500 transition-all duration-300 ease-in-out bg-transparent border-2 rounded-full hover:bg-gray-50"
                    />
                </div>

                <u-button
                    size="md"
                    class="rounded-2xl lg:hidden"
                    color="blue"
                    :icon="
                        isCollapseMenuVisible
                            ? 'material-symbols:close'
                            : 'material-symbols:menu'
                    "
                    @click="toggleMenu"
                />
            </div>
        </div>
    </header>
</template>

<script lang="ts" setup>
const appName: string = useRuntimeConfig().public.appName;

defineProps({
    pages: {
        type: Array as () => {
            name: string;
            href: string;
            icon: string;
        }[],
        required: true,
    },
});

const authStore = useAuthStore();

const isCollapseMenuVisible = ref(false);
const toggleMenu = () => {
    isCollapseMenuVisible.value = !isCollapseMenuVisible.value;
};
</script>
