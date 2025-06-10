<template>
    <u-modal>
        <u-card>
            <template #header>
                <h3 class="text-lg font-semibold">
                    Choose Template ({{ name.replace('_', ' ') }})
                </h3>
            </template>

            <div>
                <site-template-selector
                    v-model="selectedTemplate"
                    mode="grid"
                    :name="name"
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
import type { TemplateBlock } from '~/types/template';

const templateStore = useSiteTemplatesStore();
const editModeStore = useEditModeStore();

const { name } = defineProps({
    name: {
        type: Object as () => TemplateBlock,
        required: true,
    },
});

const originalTemplate = ref();
const selectedTemplate = ref();

onMounted(() => {
    originalTemplate.value = templateStore.getTemplate(name);
    selectedTemplate.value = templateStore.getTemplate(name);
});

const save = () => {
    templateStore.setTemplateForBlock(name, selectedTemplate.value).then(() => {
        //
    });

    editModeStore.addToHistory({
        name,
        oldTemplate: originalTemplate.value,
        newTemplate: selectedTemplate.value,
    });
};
</script>
