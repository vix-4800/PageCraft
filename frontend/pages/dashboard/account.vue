<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Account Settings</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full px-1 overflow-x-auto rounded">
                <u-form :state="user" class="space-y-4" @submit="submitForm">
                    <u-form-group label="Name" name="name">
                        <u-input
                            v-model="user.name"
                            color="blue"
                            size="lg"
                            required
                        />
                    </u-form-group>
                    <u-form-group label="Email" name="email">
                        <u-input
                            v-model="user.email"
                            color="blue"
                            size="lg"
                            required
                        />
                    </u-form-group>

                    <u-form-group label="Phone" name="phone">
                        <u-input
                            v-model="user.phone"
                            color="blue"
                            size="lg"
                            required
                        />
                    </u-form-group>

                    <u-form-group label="Password" name="password">
                        <u-input
                            v-model="user.password"
                            required
                            color="blue"
                            size="lg"
                            type="password"
                        />
                    </u-form-group>

                    <u-button
                        color="blue"
                        size="md"
                        label="Submit"
                        type="submit"
                    />
                </u-form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { User } from '~/types/user';
definePageMeta({
    layout: 'dashboard',
    middleware: ['auth'],
});

const authStore = useAuthStore();

const user = reactive({
    name: '',
    email: '',
    phone: '',
    password: '',
});

onMounted(async () => {
    user.name = authStore.user?.name;
    user.email = authStore.user?.email;
    user.phone = authStore.user?.phone;
});

const { $notify } = useNuxtApp();
async function submitForm() {
    const { data } = await apiFetch<{ data: User }>(`v1/users/me`, {
        method: 'PATCH',
        body: JSON.stringify(user),
    });

    if (!data.value) {
        $notify('Something went wrong', 'error');
        return;
    }

    await authStore.fetchUser();
    user.password = '';

    $notify('Account updated successfully', 'success');
}
</script>
