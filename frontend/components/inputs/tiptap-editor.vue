<template>
    <div>
        <client-only>
            <div id="editor">
                <div
                    v-if="editor"
                    class="flex flex-wrap items-center justify-between mb-2 gap-x-2"
                >
                    <div class="flex flex-wrap items-center gap-x-2">
                        <u-button
                            icon="material-symbols:format-bold"
                            color="gray"
                            size="md"
                            :class="{ 'bg-gray-300': editor.isActive('bold') }"
                            class="hover:bg-gray-300"
                            :disabled="
                                !editor.can().chain().focus().toggleBold().run()
                            "
                            @click="editor.chain().focus().toggleBold().run()"
                        />
                        <u-button
                            icon="material-symbols:format-italic"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('italic'),
                            }"
                            class="hover:bg-gray-300"
                            :disabled="
                                !editor
                                    .can()
                                    .chain()
                                    .focus()
                                    .toggleItalic()
                                    .run()
                            "
                            @click="editor.chain().focus().toggleItalic().run()"
                        />
                        <u-button
                            icon="material-symbols:format-underlined"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('underline'),
                            }"
                            class="hover:bg-gray-300"
                            :disabled="
                                !editor
                                    .can()
                                    .chain()
                                    .focus()
                                    .toggleUnderline()
                                    .run()
                            "
                            @click="
                                editor.chain().focus().toggleUnderline().run()
                            "
                        />
                        <u-button
                            icon="material-symbols:format-strikethrough"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('strike'),
                            }"
                            class="hover:bg-gray-300"
                            :disabled="
                                !editor
                                    .can()
                                    .chain()
                                    .focus()
                                    .toggleStrike()
                                    .run()
                            "
                            @click="editor.chain().focus().toggleStrike().run()"
                        />
                        <u-button
                            icon="material-symbols:code"
                            color="gray"
                            size="md"
                            :class="{ 'bg-gray-300': editor.isActive('code') }"
                            class="hover:bg-gray-300"
                            :disabled="
                                !editor.can().chain().focus().toggleCode().run()
                            "
                            @click="editor.chain().focus().toggleCode().run()"
                        />
                        <u-button
                            icon="material-symbols:format-paragraph"
                            color="gray"
                            size="md"
                            class="hover:bg-gray-300"
                            @click="editor.chain().focus().setParagraph().run()"
                        />
                        <u-button
                            icon="hugeicons:heading-01"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('heading', {
                                    level: 1,
                                }),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor
                                    .chain()
                                    .focus()
                                    .toggleHeading({ level: 1 })
                                    .run()
                            "
                        />
                        <u-button
                            icon="hugeicons:heading-02"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('heading', {
                                    level: 2,
                                }),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor
                                    .chain()
                                    .focus()
                                    .toggleHeading({ level: 2 })
                                    .run()
                            "
                        />
                        <u-button
                            icon="hugeicons:heading-03"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('heading', {
                                    level: 3,
                                }),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor
                                    .chain()
                                    .focus()
                                    .toggleHeading({ level: 3 })
                                    .run()
                            "
                        />
                        <u-button
                            icon="hugeicons:heading-04"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('heading', {
                                    level: 4,
                                }),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor
                                    .chain()
                                    .focus()
                                    .toggleHeading({ level: 4 })
                                    .run()
                            "
                        />
                        <u-button
                            icon="material-symbols:format-list-bulleted"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('bulletList'),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor.chain().focus().toggleBulletList().run()
                            "
                        />
                        <u-button
                            icon="material-symbols:format-list-numbered"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('orderedList'),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor.chain().focus().toggleOrderedList().run()
                            "
                        />
                        <u-button
                            icon="material-symbols:format-quote"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive('blockquote'),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor.chain().focus().toggleBlockquote().run()
                            "
                        />
                        <u-button
                            icon="material-symbols:format-align-left"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive({
                                    textAlign: 'left',
                                }),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor
                                    .chain()
                                    .focus()
                                    .setTextAlign('left')
                                    .run()
                            "
                        />
                        <u-button
                            icon="material-symbols:format-align-center"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive({
                                    textAlign: 'center',
                                }),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor
                                    .chain()
                                    .focus()
                                    .setTextAlign('center')
                                    .run()
                            "
                        />
                        <u-button
                            icon="material-symbols:format-align-right"
                            color="gray"
                            size="md"
                            :class="{
                                'bg-gray-300': editor.isActive({
                                    textAlign: 'right',
                                }),
                            }"
                            class="hover:bg-gray-300"
                            @click="
                                editor
                                    .chain()
                                    .focus()
                                    .setTextAlign('right')
                                    .run()
                            "
                        />
                    </div>

                    <div class="flex flex-wrap items-center gap-x-2">
                        <u-button
                            icon="material-symbols:undo"
                            color="gray"
                            size="md"
                            :disabled="
                                !editor.can().chain().focus().undo().run()
                            "
                            @click="editor.chain().focus().undo().run()"
                        />

                        <u-button
                            icon="material-symbols:redo"
                            color="gray"
                            size="md"
                            :disabled="
                                !editor.can().chain().focus().redo().run()
                            "
                            @click="editor.chain().focus().redo().run()"
                        />
                    </div>
                </div>

                <editor-content :editor="editor" />
            </div>
        </client-only>
    </div>
</template>

<script lang="ts" setup>
import { EditorContent, useEditor } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';

const { modelValue } = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
});

const editor = useEditor({
    content: modelValue,
    extensions: [StarterKit, Underline],
    editorProps: {
        attributes: {
            class: 'border max-w-full p-4 prose border-blue-500 h-[12rem] rounded-lg overflow-y-auto',
        },
    },
    onUpdate: () => {
        emit('update:modelValue', editor.value?.getHTML());
    },
});

const emit = defineEmits(['update:modelValue']);

onBeforeUnmount(() => {
    editor.destroy();
});

watch(
    () => editor.value?.getHTML(),
    (value) => {
        emit('update:modelValue', value);
    }
);
</script>
