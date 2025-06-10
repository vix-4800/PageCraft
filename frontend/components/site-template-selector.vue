<template>
    <div id="template-selector">
        <template v-if="mode === 'select'">
            <u-select-menu
                :model-value="modelValue"
                :items="options"
                color="blue"
                :disabled="options.length < 2"
                value-attribute="value"
                :ui-menu="{
                    height: 'max-h-96',
                }"
                @update:model-value="emit('update:modelValue', $event)"
            >
                <template #option="{ option }">
                    <img :src="option.img" class="object-cover w-56 h-32" />
                    <span class="ml-2">{{ option.label }}</span>
                </template>
            </u-select-menu>
        </template>

        <template v-else>
            <div class="grid grid-cols-3 gap-4">
                <div
                    v-for="option in options"
                    :key="option.value"
                    class="p-2 border-2 rounded-lg cursor-pointer"
                    :class="{ 'border-blue-500': modelValue === option.value }"
                    @click="emit('update:modelValue', option.value)"
                >
                    <img
                        :src="option.img"
                        class="object-cover w-full h-32 mb-2"
                    />
                    <div class="font-medium text-center">
                        {{ option.label }}
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script lang="ts" setup>
import { TemplateConfig } from '~/config/templates';
import { TemplateBlock } from '~/types/template';

const { name } = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    mode: {
        type: String as () => Mode,
        required: true,
    },
    name: {
        type: TemplateBlock,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue']);

const options = computed(() => TemplateConfig[name]);

enum Mode {
    Select = 'select',
    Grid = 'grid',
}
</script>
