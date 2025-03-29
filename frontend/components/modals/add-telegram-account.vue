<template>
    <u-modal>
        <u-card>
            <template #header>
                <h3 class="text-lg font-semibold">Add Telegram Account</h3>
            </template>

            <template #footer>
                <div class="flex justify-end gap-2">
                    <u-button
                        label="Cancel"
                        color="red"
                        icon="material-symbols:close"
                        @click="modal.close()"
                    />
                    <u-button
                        color="blue"
                        icon="material-symbols:save"
                        label="Save"
                        @click="save"
                    />
                </div>
            </template>
        </u-card>
    </u-modal>
</template>

<script lang="ts" setup>
const modal = useModal();
const { $notify } = useNuxtApp();

const save = () => {
    modal.close();
    $notify('Telegram account added successfully', 'success');
};
</script>
