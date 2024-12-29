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
            <u-form-group size="lg" name="name" required>
                <u-input
                    v-model="credentials.name"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Name"
                    required
                    icon="material-symbols:person"
                />
            </u-form-group>

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

            <u-form-group size="lg" name="phone" required>
                <u-input
                    v-model="credentials.phone"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    variant="none"
                    placeholder="Phone"
                    required
                    icon="material-symbols:phone-enabled"
                />
            </u-form-group>

            <u-form-group size="lg" name="password" required>
                <u-input
                    v-model="credentials.password"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    type="password"
                    variant="none"
                    placeholder="Password"
                    required
                    icon="material-symbols:lock"
                />
            </u-form-group>

            <u-form-group size="lg" name="password_confirmation" required>
                <u-input
                    v-model="credentials.password_confirmation"
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500"
                    type="password"
                    variant="none"
                    placeholder="Password confirmation"
                    required
                    icon="material-symbols:lock"
                />
            </u-form-group>

            <div class="flex justify-center gap-4">
                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    block
                    label="Register"
                    type="submit"
                    icon="material-symbols:person-add"
                />

                <u-button
                    class="bg-gray-800 border border-gray-600 rounded-lg shadow-xl w-36 hover:ring-1 te focus:outline-none focus:ring-2 focus:ring-gray-500 hover:bg-gray-700"
                    size="lg"
                    block
                    label="Login"
                    to="/login"
                    icon="material-symbols:login-rounded"
                />
            </div>
        </u-form>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'auth',
});

const credentials = reactive({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const { $notify } = useNuxtApp();
const submitForm = async () => {
    if (credentials.password !== credentials.password_confirmation) {
        $notify('Passwords do not match', 'warning');
        return;
    }

    await useAuthStore().register(credentials);
};
</script>
