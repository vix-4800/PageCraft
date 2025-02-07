<template>
    <u-modal>
        <u-card>
            <template #header>
                <h3 class="text-lg font-semibold">
                    Choose Template ({{ block.replace('_', ' ') }})
                </h3>
            </template>

            <div></div>

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
import { TemplateBlock } from '~/types/site_template';

const modal = useModal();
const templateStore = useSiteTemplatesStore();

defineProps({
    block: {
        type: Object as () => TemplateBlock,
        required: true,
    },
});

const save = () => {
    const temp = templateStore.getTemplate(TemplateBlock.Header);

    templateStore
        .setTemplateForBlock(
            TemplateBlock.Header,
            temp === 'minimalistic' ? 'default' : 'minimalistic'
        )
        .then(() => {
            modal.close();
        });
};
</script>
