<template>
    <div>
        <div v-if="editor" class="flex flex-wrap items-center mb-2 gap-x-2">
            <u-button
                label="Bold"
                color="gray"
                size="md"
                :class="{ 'bg-gray-300': editor.isActive('bold') }"
                :disabled="!editor.can().chain().focus().toggleBold().run()"
                @click="editor.chain().focus().toggleBold().run()"
            />

            <u-button
                label="Italic"
                color="gray"
                size="md"
                :class="{ 'bg-gray-300': editor.isActive('italic') }"
                :disabled="!editor.can().chain().focus().toggleItalic().run()"
                @click="editor.chain().focus().toggleItalic().run()"
            />

            <!-- <u-button
                label="Underline"
                color="gray"
                size="md"
                :class="{ 'bg-gray-300': editor.isActive('underline') }"
                :disabled="!editor.can().chain().focus().toggleUnderline().run()"
                @click="editor.chain().focus().toggleUnderline().run()"
            /> -->

            <u-button
                label="Undo"
                color="gray"
                size="md"
                :disabled="!editor.can().chain().focus().undo().run()"
                @click="editor.chain().focus().undo().run()"
            />

            <u-button
                label="Redo"
                color="gray"
                size="md"
                :disabled="!editor.can().chain().focus().redo().run()"
                @click="editor.chain().focus().redo().run()"
            />
        </div>
        <editor-content :editor="editor" />
    </div>
</template>

<script lang="ts" setup>
import { EditorContent, useEditor } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';

const editor = useEditor({
    content: "<p>I'm running Tiptap with Vue.js. 🎉</p>",
    extensions: [
        StarterKit,
        // Underline
    ],
    editorProps: {
        attributes: {
            class: 'border p-4 prose border-blue-500 h-[12rem] rounded-lg overflow-y-auto',
        },
    },
});
</script>
