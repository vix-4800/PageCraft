<template>
    <u-modal>
        <u-card>
            <template #header>
                <h3 class="text-lg font-semibold">
                    Choose Template ({{ block.replace('_', ' ') }})
                </h3>
            </template>

            <div>
                <site-template-selector
                    v-model="selectedTemplate"
                    mode="grid"
                    :block="block"
                    class="mt-2"
                />
            </div>

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
import type { TemplateBlock } from '~/types/site_template';

const modal = useModal();
const templateStore = useSiteTemplatesStore();
const editModeStore = useEditModeStore();

const { block } = defineProps({
    block: {
        type: Object as () => TemplateBlock,
        required: true,
    },
});

const selectedTemplate = ref();

onMounted(() => {
    selectedTemplate.value = templateStore.getTemplate(block);
});

const save = () => {
    templateStore
        .setTemplateForBlock(block, selectedTemplate.value)
        .then(() => {
            modal.close();
        });

    editModeStore.addToHistory('Change template');
};
</script>
