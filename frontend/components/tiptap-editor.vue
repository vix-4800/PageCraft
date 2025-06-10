<template>
    <div>
        <client-only>
            <div id="editor">
                <div
                    v-if="editor"
                    class="flex flex-wrap items-center justify-between mb-2 gap-x-2"
                >
                    <div class="flex flex-wrap items-center gap-x-2">
                        <u-tooltip text="Bold" :popper="{ placement: 'top' }">
                            <u-button
                                icon="material-symbols:format-bold"
                                color="gray"
                                size="sm"
                                :class="{
                                    'bg-gray-300': editor.isActive('bold'),
                                }"
                                class="hover:bg-gray-300"
                                :disabled="
                                    !editor
                                        .can()
                                        .chain()
                                        .focus()
                                        .toggleBold()
                                        .run()
                                "
                                @click="
                                    editor.chain().focus().toggleBold().run()
                                "
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
                                    !editor
                                        .can()
                                        .chain()
                                        .focus()
                                        .toggleItalic()
                                        .run()
                                "
                                @click="
                                    editor.chain().focus().toggleItalic().run()
                                "
                            />
                        </u-tooltip>

                        <u-tooltip
                            text="Underline"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-underlined"
                                color="gray"
                                size="sm"
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
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleUnderline()
                                        .run()
                                "
                            />
                        </u-tooltip>

                        <u-tooltip
                            text="Strikethrough"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-strikethrough"
                                color="gray"
                                size="sm"
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
                                @click="
                                    editor.chain().focus().toggleStrike().run()
                                "
                            />
                        </u-tooltip>

                        <u-tooltip text="Code" :popper="{ placement: 'top' }">
                            <u-button
                                icon="material-symbols:code"
                                color="gray"
                                size="sm"
                                :class="{
                                    'bg-gray-300': editor.isActive('code'),
                                }"
                                class="hover:bg-gray-300"
                                :disabled="
                                    !editor
                                        .can()
                                        .chain()
                                        .focus()
                                        .toggleCode()
                                        .run()
                                "
                                @click="
                                    editor.chain().focus().toggleCode().run()
                                "
                            />
                        </u-tooltip>

                        <u-tooltip
                            text="Paragraph"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-paragraph"
                                color="gray"
                                size="sm"
                                class="hover:bg-gray-300"
                                @click="
                                    editor.chain().focus().setParagraph().run()
                                "
                            />
                        </u-tooltip>

                        <u-tooltip
                            text="Heading 1"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="hugeicons:heading-01"
                                color="gray"
                                size="sm"
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
                        </u-tooltip>

                        <u-tooltip
                            text="Heading 2"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="hugeicons:heading-02"
                                color="gray"
                                size="sm"
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
                        </u-tooltip>

                        <u-tooltip
                            text="Heading 3"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="hugeicons:heading-03"
                                color="gray"
                                size="sm"
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
                        </u-tooltip>

                        <u-tooltip
                            text="Heading 4"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="hugeicons:heading-04"
                                color="gray"
                                size="sm"
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
                        </u-tooltip>

                        <u-tooltip
                            text="Bulleted List"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-list-bulleted"
                                color="gray"
                                size="sm"
                                :class="{
                                    'bg-gray-300':
                                        editor.isActive('bulletList'),
                                }"
                                class="hover:bg-gray-300"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleBulletList()
                                        .run()
                                "
                            />
                        </u-tooltip>

                        <u-tooltip
                            text="Numbered List"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-list-numbered"
                                color="gray"
                                size="sm"
                                :class="{
                                    'bg-gray-300':
                                        editor.isActive('orderedList'),
                                }"
                                class="hover:bg-gray-300"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleOrderedList()
                                        .run()
                                "
                            />
                        </u-tooltip>

                        <u-tooltip
                            text="Blockquote"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-quote"
                                color="gray"
                                size="sm"
                                :class="{
                                    'bg-gray-300':
                                        editor.isActive('blockquote'),
                                }"
                                class="hover:bg-gray-300"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleBlockquote()
                                        .run()
                                "
                            />
                        </u-tooltip>

                        <u-tooltip
                            text="Align Left"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-align-left"
                                color="gray"
                                size="sm"
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
                        </u-tooltip>

                        <u-tooltip
                            text="Align Center"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-align-center"
                                color="gray"
                                size="sm"
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
                        </u-tooltip>

                        <u-tooltip
                            text="Align Right"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:format-align-right"
                                color="gray"
                                size="sm"
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
                        </u-tooltip>

                        <u-tooltip
                            text="Add Video"
                            :popper="{ placement: 'top' }"
                        >
                            <u-button
                                icon="material-symbols:youtube-activity"
                                size="sm"
                                color="gray"
                                class="hover:bg-gray-300"
                                @click="addVideo"
                            />
                        </u-tooltip>
                    </div>

                    <div class="flex flex-wrap items-center gap-x-2">
                        <u-tooltip text="Undo" :popper="{ placement: 'top' }">
                            <u-button
                                icon="material-symbols:undo"
                                color="gray"
                                size="sm"
                                :disabled="
                                    !editor.can().chain().focus().undo().run()
                                "
                                @click="editor.chain().focus().undo().run()"
                            />
                        </u-tooltip>

                        <u-tooltip text="Redo" :popper="{ placement: 'top' }">
                            <u-button
                                icon="material-symbols:redo"
                                color="gray"
                                size="sm"
                                :disabled="
                                    !editor.can().chain().focus().redo().run()
                                "
                                @click="editor.chain().focus().redo().run()"
                            />
                        </u-tooltip>
                    </div>
                </div>

                <tiptap-bubble-menu :editor="editor" />

                <editor-content :editor="editor" />

                <div
                    class="text-sm text-gray-500 text-end"
                    :class="{
                        'character-count': true,
                        'character-count--warning':
                            editor.storage.characterCount.characters() ===
                            limit,
                    }"
                >
                    {{ editor.storage.characterCount.characters() }} /
                    {{ limit }} characters
                </div>
            </div>
        </client-only>
    </div>
</template>

<script lang="ts" setup>
import { EditorContent, useEditor } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import TextAlign from '@tiptap/extension-text-align';
import Placeholder from '@tiptap/extension-placeholder';
import CharacterCount from '@tiptap/extension-character-count';
import Youtube from '@tiptap/extension-youtube';

const { modelValue, limit } = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    limit: {
        type: Number,
        default: 1000,
    },
});

const editor = useEditor({
    content: modelValue,
    extensions: [
        StarterKit,
        Underline,
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        Placeholder.configure({
            placeholder: 'Write something...',
        }),
        CharacterCount.configure({
            limit: limit,
        }),
        Youtube.configure({
            nocookie: true,
        }),
    ],
    editorProps: {
        attributes: {
            class: 'border max-w-full p-4 prose border-blue-500 h-144 rounded-lg overflow-y-auto',
        },
    },
    onUpdate: () => {
        emit('update:modelValue', editor.value?.getHTML());
    },
});

const emit = defineEmits(['update:modelValue']);

watch(
    () => editor.value?.getHTML(),
    (value) => {
        emit('update:modelValue', value);
    }
);

const addVideo = () => {
    const url = prompt('Enter YouTube URL');

    editor.value.commands.setYoutubeVideo({
        src: url,
        width: 800,
        height: 450,
    });
};
</script>

<style lang="scss">
.tiptap {
    :first-child {
        margin-top: 0;
    }

    p.is-editor-empty:first-child::before {
        color: var(--gray-4);
        content: attr(data-placeholder);
        float: left;
        height: 0;
        pointer-events: none;
    }
}

/* Youtube embed */
div[data-youtube-video] {
    cursor: move;
    padding-right: 1.5rem;

    iframe {
        border: 0.5rem solid var(--black-contrast);
        border-radius: 0.5rem;
        display: block;
        min-height: 200px;
        min-width: 200px;
        outline: 0px solid transparent;
    }

    &.ProseMirror-selectednode iframe {
        outline: 3px solid var(--purple);
        transition: outline 0.15s;
    }
}
</style>
