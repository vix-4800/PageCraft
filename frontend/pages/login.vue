<template>
    <div>
        <div class="flex justify-center mb-4">
            <nuxt-link
                to="/"
                class="w-24 transition duration-200 opacity-50 hover:opacity-100 max-h-24"
            >
                <nuxt-img
                    src="/logo.png"
                    :alt="useRuntimeConfig().public.appName"
                />
            </nuxt-link>
        </div>

        <u-form :state="credentials" class="space-y-6" @submit="submitForm">
            <u-form-group size="lg" name="email" required>
                <u-input
                    v-model="credentials.email"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Email"
                    type="email"
                    required
                    icon="material-symbols:mail"
                />
            </u-form-group>

            <u-form-group name="password" size="lg" required>
                <u-input
                    v-model="credentials.password"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    type="password"
                    placeholder="Password"
                    required
                    variant="none"
                    icon="material-symbols:lock"
                />
            </u-form-group>

            <u-checkbox
                v-model="credentials.remember"
                color="blue"
                class="text-gray-100"
            >
                <template #label>
                    <span class="italic text-gray-100">Remember me</span>
                </template>
            </u-checkbox>

            <u-button
                class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                size="lg"
                block
                label="Login"
                type="submit"
            />
        </u-form>

        <u-divider
            label="Don't have an account?"
            :ui="{
                border: { base: 'border-gray-500' },
                label: 'text-gray-500',
                container: { horizontal: 'my-4' },
            }"
        />

        <u-button
            class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
            size="lg"
            block
            label="Register"
            to="/register"
        />
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'auth',
    middleware: [],
});

const credentials = reactive({
    email: '',
    password: '',
    remember: true,
});

const submitForm = async () => {
    await useAuthStore().login(credentials);
};
</script>
