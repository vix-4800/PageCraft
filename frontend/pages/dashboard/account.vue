<template>
    <div
        class="overflow-hidden bg-white border rounded-xl border-slate-200 sm:col-span-12"
    >
        <div class="px-6 pt-6">
            <h2 class="text-2xl font-bold">Account Settings</h2>
        </div>
        <div class="p-6">
            <div class="min-w-full px-1 overflow-x-auto rounded">
                <UForm :state="state" class="space-y-4" @submit="submitForm">
                    <UFormGroup label="Name" name="name">
                        <UInput v-model="state.name" />
                    </UFormGroup>
                    <UFormGroup label="Email" name="email">
                        <UInput v-model="state.email" />
                    </UFormGroup>

                    <UFormGroup label="Phone" name="phone">
                        <UInput v-model="state.phone" />
                    </UFormGroup>

                    <UFormGroup label="Password" name="password">
                        <UInput v-model="state.password" type="password" />
                    </UFormGroup>

                    <div class="flex gap-2">
                        <UButton type="submit">Submit</UButton>
                    </div>
                </UForm>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
definePageMeta({
    layout: 'dashboard',
});

const authStore = useAuthStore();

const state = reactive({
    name: undefined,
    email: undefined,
    phone: undefined,
    password: undefined,
});

onMounted(async () => {
    authStore.fetchUser();

    state.name = authStore.user?.name;
    state.email = authStore.user?.email;
    state.phone = authStore.user?.phone;
});

async function submitForm() {
    const apiUrl: string = useRuntimeConfig().public.apiUrl;

    await $fetch(`${apiUrl}/v1/products`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${authStore.authToken}`,
        },
        body: {
            name: state.name,
            email: state.email,
            phone: state.phone,
            password: state.password,
        },
    });

    await authStore.fetchUser();

    state.name = authStore.user?.name;
    state.email = authStore.user?.email;
    state.phone = authStore.user?.phone;
}
</script>
