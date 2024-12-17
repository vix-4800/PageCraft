<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Account Settings</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full px-1 overflow-x-auto rounded">
                <u-form class="space-y-4" @submit="submitForm">
                    <u-form-group label="Name" name="name">
                        <u-input
                            color="blue"
                            size="lg"
                            v-model="user.name"
                            required
                        />
                    </u-form-group>
                    <u-form-group label="Email" name="email">
                        <u-input
                            color="blue"
                            size="lg"
                            v-model="user.email"
                            required
                        />
                    </u-form-group>

                    <u-form-group label="Phone" name="phone">
                        <u-input
                            color="blue"
                            size="lg"
                            v-model="user.phone"
                            required
                        />
                    </u-form-group>

                    <u-form-group label="Password" name="password">
                        <u-input
                            required
                            color="blue"
                            size="lg"
                            v-model="user.password"
                            type="password"
                        />
                    </u-form-group>

                    <u-button color="blue" size="md" type="submit">
                        Submit
                    </u-button>
                </u-form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
});

const authStore = useAuthStore();

const user = reactive({
    name: undefined,
    email: undefined,
    phone: undefined,
    password: undefined,
});

onMounted(async () => {
    await authStore.fetchUser();

    user.name = authStore.user?.name;
    user.email = authStore.user?.email;
    user.phone = authStore.user?.phone;
});

const { $notify } = useNuxtApp();
async function submitForm() {
    const apiUrl: string = useRuntimeConfig().public.apiUrl;

    await useFetch(`${apiUrl}/v1/users/me`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${authStore.authToken}`,
        },
        body: {
            name: user.name,
            email: user.email,
            phone: user.phone,
            password: user.password,
        },
    }).then(async (result) => {
        if (result.error) {
            $notify('Something went wrong', 'error');
            return;
        }

        await authStore.fetchUser();

        user.name = authStore.user?.name;
        user.email = authStore.user?.email;
        user.phone = authStore.user?.phone;

        $notify('Account updated successfully', 'success');
    });
}
</script>
