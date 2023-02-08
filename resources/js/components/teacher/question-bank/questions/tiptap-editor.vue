<template>
  <div class="border rounded p-3 flex flex-col">
    <div class="flex flex-row  border-b pb-2 px-3">
      <div class="flex flex-row gap-2">
        <button
          type="button"
          @click="editor.chain().focus().undo().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:undo"
          />
        </button>
        <button
          type="button"
          @click="editor.chain().focus().redo().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:redo"
          />
        </button>
      </div>
      <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />
      <div class="flex flex-row gap-2">
        <button
          type="button"
          :class="{ 'bg-black bg-opacity-10 rounded': editor.isActive('bold') }"
          @click="editor.chain().focus().toggleBold().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-bold"
          />
        </button>
        <button
          type="button"
          :class="{ 'bg-black bg-opacity-10 rounded': editor.isActive('italic') }"
          @click="editor.chain().focus().toggleItalic().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-italic"
          />
        </button>

        <button
          type="button"
          :class="{ 'bg-black bg-opacity-10 rounded': editor.isActive('strike') }"
          @click="editor.chain().focus().toggleStrike().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-strikethrough"
          />
        </button>

        <button
          type="button"
          :class="{ 'bg-black bg-opacity-10 rounded': editor.isActive('underline') }"
          @click="editor.chain().focus().toggleUnderline().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-underline"
          />
        </button>
      </div>
      <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />
      <div class="flex flex-row gap-2">
        <button
          type="button"
          :class="{ 'bg-black bg-opacity-10 rounded': editor.isActive('bulletList') }"
          @click="editor.chain().focus().toggleBulletList().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-list-bulleted"
          />
        </button>

        <button
          type="button"
          :class="{ 'bg-black bg-opacity-10 rounded': editor.isActive('orderedList') }"
          @click="editor.chain().focus().toggleOrderedList().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-list-numbered"
          />
        </button>
        <button
          type="button"
          :class="{ 'bg-black bg-opacity-10 rounded': editor.isActive('orderedList') }"
          @click="editor.chain().focus().toggleOrderedList().run()"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-list-numbered"
          />
        </button>
        <button
          @click="editor.chain().focus().liftListItem('listItem').run()"
          type="button"
          :disabled="!editor.can().liftListItem('listItem')"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-indent-decrease"
          />
        </button>
        <button
          type="button"
          @click="editor.chain().focus().sinkListItem('listItem').run()"
          :disabled="!editor.can().sinkListItem('listItem')"
        >
          <span
            class="iconify text-2xl"
            data-icon="mdi:format-indent-increase"
          />
        </button>
      </div>
    </div>
    <editor-content
      class="pt-3"
      :editor="editor"
    />
    <input
      type="hidden"
      v-model="html"
      :name="name"
    >
  </div>
</template>
<script>
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import Image from '@tiptap/extension-image';

export default {
  components: {
    EditorContent,
  },
  props: {
    initialContent: {
      type: String,
      required: true,
      default: '<em>editable text</em>',
    },
    name: {
      type: String,
      required: true,
      default: 'body',
    },
  },
  emits: ['update'],
  data() {
    return {
      html: '',
      json: '',
      editor: null,
    };
  },
  created() {
    Image.configure({
      inline: true,
      allowBase64: true,
    });
    this.editor = new Editor({
      content: this.initialContent,
      extensions: [StarterKit, Underline, Image],
      editorProps: {
        attributes: {
          class: 'prose dark:prose-invert m-3 focus:outline-none',
        },
      },
    });
    this.html = this.editor.getHTML();
    this.json = this.editor.getJSON();
    this.editor.on('update', () => {
      this.html = this.editor.getHTML();
      this.json = this.editor.getJSON();
      this.$emit('update', this.html);
    });
  },
  beforeUnmount() {
    this.editor.destroy();
  },
};
</script>

<style lang="css" scoped></style>
