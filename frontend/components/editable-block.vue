<template>
    <div
        :class="{
            'hover:ring-2 hover:ring-red-500': editModeStore.enabled,
        }"
        @contextmenu.prevent="openMenu"
    >
        <slot></slot>

        <u-context-menu
            v-model="isOpen"
            class="z-100"
            :virtual-element="virtualElement"
            :popper="{ placement: 'right' }"
        >
            <div class="flex flex-col">
                <u-button
                    label="Change template"
                    icon="material-symbols:edit"
                    color="gray"
                    @click="changeTemplate(name)"
                />
                <u-button
                    label="Hide"
                    icon="material-symbols:close"
                    color="red"
                />
            </div>
        </u-context-menu>
    </div>
</template>

<script lang="ts" setup>
import type { TemplateBlock } from '~/types/template';

const { name } = defineProps({
    name: {
        type: String as () => TemplateBlock,
        required: true,
    },
});

const editModeStore = useEditModeStore();

const { isOpen, virtualElement, openMenu, changeTemplate } = useContextMenu();
</script>
