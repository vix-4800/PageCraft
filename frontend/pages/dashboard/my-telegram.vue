<template>
    <div>
        <dashboard-page-name title="My Telegram">
            <template #actions>
                <u-button
                    v-if="!account"
                    color="blue"
                    size="md"
                    label="Add Account"
                    icon="material-symbols:add"
                    @click="add"
                />
            </template>
        </dashboard-page-name>

        <page-in-progress />
    </div>
</template>

<script lang="ts" setup>
import AddTelegramAccount from '~/components/modals/add-telegram-account.vue';

definePageMeta({
    layout: 'dashboard',
    middleware: ['auth', 'verified'],
});

const account = ref(null);
onMounted(() => {
    // Check if account already exists
});

const overlay = useOverlay();
const add = () => {
    overlay.create(AddTelegramAccount);
};
</script>
