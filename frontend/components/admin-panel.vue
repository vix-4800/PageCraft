<template>
    <div
        id="edit-panel"
        class="top-0 z-[100] flex flex-col sm:flex-row justify-between items-center h-auto sm:h-12 px-4 backdrop-blur-lg bg-gray-800/80 border-b border-gray-700 shadow-xl transition-all duration-300"
        :class="{
            'sticky sm:h-16': editModeStore.enabled,
        }"
    >
        <div class="flex items-center space-x-3">
            <span
                class="flex items-center self-center text-lg font-semibold text-gray-100"
            >
                <span class="hidden sm:inline">Editor Mode:</span>
                <span
                    class="ml-2 font-bold transition-colors duration-300"
                    :class="
                        editModeStore.enabled
                            ? 'text-emerald-400'
                            : 'text-rose-400'
                    "
                >
                    {{ editModeStore.enabled ? 'ACTIVE' : 'INACTIVE' }}
                </span>
            </span>

            <div
                v-if="editModeStore.hasChanges"
                class="flex items-center space-x-1 text-sm"
            >
                <span
                    class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"
                ></span>
                <span class="text-amber-400">Unsaved changes</span>
            </div>
        </div>

        <div class="flex items-center py-2 space-x-2 sm:py-0">
            <u-button
                v-if="editModeStore.hasChanges"
                label="Save"
                icon="material-symbols:save-outline"
                color="emerald"
                @click="saveChanges"
            />

            <u-button
                v-if="editModeStore.hasChanges"
                label="Reset"
                icon="material-symbols:refresh"
                color="gray"
                @click="editModeStore.resetChanges()"
            />

            <u-button
                :label="editModeStore.enabled ? 'Disable' : 'Edit mode'"
                :icon="
                    editModeStore.enabled
                        ? 'material-symbols:close'
                        : 'material-symbols:edit'
                "
                :color="editModeStore.enabled ? 'rose' : 'gray'"
                class="font-medium transition-all"
                :class="{
                    'hover:bg-rose-600 ': editModeStore.enabled,
                    'hover:bg-gray-700 hover:text-gray-100':
                        !editModeStore.enabled,
                }"
                @click="editModeStore.toggle()"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
defineShortcuts({
    ctrl_e: () => editModeStore.toggle(),
    ctrl_s: () => saveChanges(),
});

const editModeStore = useEditModeStore();

const saveChanges = async () => {
    await editModeStore.save();
};
</script>
