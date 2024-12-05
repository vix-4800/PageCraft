<template>
    <div class="flex flex-col justify-center h-screen max-w-2xl mx-auto">
        <div
            class="flex flex-col gap-4 p-6 text-gray-300 border border-gray-600 rounded-lg shadow-2xl background-blur-md"
        >
            <div class="flex justify-center">
                <nuxt-link
                    to="/"
                    class="w-24 transition duration-200 opacity-50 hover:opacity-100 max-h-24"
                >
                    <img src="@img/logo.png" :alt="config.public.appName" />
                </nuxt-link>
            </div>

            <form
                class="flex flex-col gap-4"
                @submit.prevent="login(state.email, state.password)"
            >
                <div class="flex flex-col gap-1">
                    <label
                        for="email"
                        class="w-max"
                        style="font-family: Merriweather"
                    >
                        Email
                    </label>
                    <input
                        id="email"
                        v-model="state.email"
                        type="email"
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>

                <div class="flex flex-col gap-1">
                    <label
                        for="password"
                        class="w-max"
                        style="font-family: Merriweather"
                    >
                        Password
                    </label>
                    <input
                        id="password"
                        v-model="state.password"
                        type="password"
                        class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        required
                        autocomplete="current-password"
                    />
                </div>

                <button
                    type="submit"
                    class="w-full py-2 mt-8 text-gray-300 bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:bg-gray-700"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'empty',
});

const config = useRuntimeConfig();
const store = useAuthStore();

const state = reactive({
    email: '',
    password: '',
});

const login = async (email: string, password: string) => {
    await store.login(email, password);
};
</script>
