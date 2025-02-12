<template>
    <bubble-menu
        v-if="editor"
        :editor="editor"
        :tippy-options="{ duration: 100 }"
    >
        <div
            class="flex p-1 bg-white border border-gray-300 rounded-md gap-x-1 bubble-menu"
        >
            <u-tooltip text="Bold" :popper="{ placement: 'top' }">
                <u-button
                    icon="material-symbols:format-bold"
                    color="gray"
                    size="sm"
                    :class="{
                        'bg-gray-300': editor.isActive('bold'),
                    }"
                    class="hover:bg-gray-300"
                    :disabled="!editor.can().chain().focus().toggleBold().run()"
                    @click="editor.chain().focus().toggleBold().run()"
                />
            </u-tooltip>

            <u-tooltip text="Italic" :popper="{ placement: 'top' }">
                <u-button
                    icon="material-symbols:format-italic"
                    color="gray"
                    size="sm"
                    :class="{
                        'bg-gray-300': editor.isActive('italic'),
                    }"
                    class="hover:bg-gray-300"
                    :disabled="
                        !editor.can().chain().focus().toggleItalic().run()
                    "
                    @click="editor.chain().focus().toggleItalic().run()"
                />
            </u-tooltip>

            <u-tooltip text="Underline" :popper="{ placement: 'top' }">
                <u-button
                    icon="material-symbols:format-underlined"
                    color="gray"
                    size="sm"
                    :class="{
                        'bg-gray-300': editor.isActive('underline'),
                    }"
                    class="hover:bg-gray-300"
                    :disabled="
                        !editor.can().chain().focus().toggleUnderline().run()
                    "
                    @click="editor.chain().focus().toggleUnderline().run()"
                />
            </u-tooltip>

            <u-tooltip text="Strikethrough" :popper="{ placement: 'top' }">
                <u-button
                    icon="material-symbols:format-strikethrough"
                    color="gray"
                    size="sm"
                    :class="{
                        'bg-gray-300': editor.isActive('strike'),
                    }"
                    class="hover:bg-gray-300"
                    :disabled="
                        !editor.can().chain().focus().toggleStrike().run()
                    "
                    @click="editor.chain().focus().toggleStrike().run()"
                />
            </u-tooltip>
        </div>
    </bubble-menu>
</template>

<script lang="ts" setup>
import { BubbleMenu } from '@tiptap/vue-3';

defineProps({
    editor: {
        type: Object,
        required: true,
    },
});
</script>
