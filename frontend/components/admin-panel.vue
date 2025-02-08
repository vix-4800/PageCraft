<template>
    <div
        id="edit-panel"
        class="top-0 z-[100] flex flex-col sm:flex-row justify-between items-center h-auto sm:h-12 bg-gray-500"
        :class="{
            sticky: editModeStore.enabled,
        }"
    >
        <span class="self-center ml-2 text-lg font-semibold text-gray-100">
            Edit Mode:
            <span
                class="font-bold"
                :class="`text-${editModeStore.enabled ? 'green' : 'red'}-500`"
            >
                {{ editModeStore.enabled ? 'ON' : 'OFF' }}
            </span>
        </span>

        <u-button
            :label="editModeStore.enabled ? 'Disable' : `Edit mode`"
            :icon="
                editModeStore.enabled
                    ? 'material-symbols:close'
                    : 'material-symbols:edit'
            "
            :color="editModeStore.enabled ? 'red' : 'gray'"
            class="m-2"
            @click="toggleEditMode"
        />
    </div>
</template>

<script lang="ts" setup>
const editModeStore = useEditModeStore();

const toggleEditMode = () => {
    editModeStore.toggle();

    if (!editModeStore.enabled) {
        isOpen.value = false;
    }
};
</script>
