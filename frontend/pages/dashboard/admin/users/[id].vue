<template>
    <div v-if="user">
        <dashboard-page-name
            title="User"
            :subtitle="`#${user?.id}`"
            :description="
                'Registered on ' + new Date(user.registered_at).toDateString()
            "
        >
            <template #actions>
                <u-button
                    v-if="!user.email_verified_at"
                    label="Verify User"
                    icon="material-symbols:verified"
                    color="blue"
                    size="md"
                    @click="verifyUser"
                />

                <u-button
                    color="red"
                    size="md"
                    label="Delete User"
                    icon="material-symbols:delete"
                    @click="deleteUser"
                />
            </template>
        </dashboard-page-name>

        <div>
            <u-card :ui="{ background: 'bg-slate-100' }">
                <template #header>
                    <h3 class="text-lg font-semibold">Profile Info</h3>
                </template>

                <u-form
                    :schema="schema"
                    :state="user"
                    class="space-y-4"
                    @submit="submitForm"
                >
                    <u-form-group label="Name" name="name">
                        <u-input v-model="user.name" color="blue" size="lg" />
                    </u-form-group>

                    <u-form-group label="Email" name="email">
                        <u-input v-model="user.email" color="blue" size="lg" />
                    </u-form-group>

                    <u-form-group label="Phone" name="phone">
                        <u-input v-model="user.phone" color="blue" size="lg" />
                    </u-form-group>

                    <u-form-group label="Role" name="role">
                        <u-select
                            v-model="user.role"
                            color="blue"
                            :options="roles"
                            size="lg"
                        />
                    </u-form-group>

                    <u-button
                        color="blue"
                        size="md"
                        label="Submit"
                        icon="material-symbols:save"
                        type="submit"
                    />
                </u-form>
            </u-card>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { UserRole, type User } from '~/types/user';
import { z } from 'zod';
import type { FormSubmitEvent } from '#ui/types';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'dashboard', 'verified'],
});

const { $notify } = useNuxtApp();
const route = useRoute();

const user = ref<User>();
onMounted(async () => {
    const { data } = await apiFetch<{ data: User }>(
        `v1/users/${route.params.id}`
    );

    user.value = data;
});

const roles = [
    { label: 'Admin', value: UserRole.ADMIN },
    { label: 'Customer', value: UserRole.CUSTOMER },
];

const schema = z.object({
    email: z.string().min(1, 'Email is required').email('Email is invalid'),
    name: z.string().min(1, 'Name is required'),
    phone: z.string().min(1, 'Phone is required'),
    role: z.string().min(1, 'Role is required'),
});

type Schema = z.output<typeof schema>;
const submitForm = async (event: FormSubmitEvent<Schema>) => {
    await apiFetch(`v1/users/${route.params.id}`, {
        method: 'PUT',
        body: event.data,
    });

    $notify('User updated successfully', 'success');
};

const verifyUser = async () => {
    await apiFetch(`v1/users/${route.params.id}/verify`, {
        method: 'POST',
    });

    $notify('User verified successfully', 'success');
};

const deleteUser = async () => {
    await apiFetch(`v1/users/${route.params.id}`, {
        method: 'DELETE',
    });

    navigateTo('/dashboard/admin/users');
    $notify('User deleted successfully', 'success');
};
</script>
