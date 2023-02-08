<template>
  <div class="border rounded p-3 flex flex-col w-[640px]">
    <div class="flex flex-col gap-2">
      <div class="flex flex-row border-b pb-2 px-3">
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
            type="button"
            @click="editor.chain().focus().liftListItem('listItem').run()"
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
      <div class="flex flex-row border-b pb-2 px-3">
        <div class="flex flex-row gap-2">
          <button
            type="button"
            @click="editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table"
            />
          </button>
          <button
            type="button"
            @click="editor.chain().focus().addColumnBefore().run()"
            :disabled="!editor.can().addColumnBefore()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-column-plus-before"
            />
          </button>
          <button
            type="button"
            @click="editor.chain().focus().addColumnAfter().run()"
            :disabled="!editor.can().addColumnAfter()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-column-plus-after"
            />
          </button>
          <button
            type="button"
            @click="editor.chain().focus().deleteColumn().run()"
            :disabled="!editor.can().deleteColumn()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-column-remove"
            />
          </button>
          <button
            type="button"
            @click="editor.chain().focus().addRowBefore().run()"
            :disabled="!editor.can().addRowBefore()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-row-plus-before"
            />
          </button>
          <button
            type="button"
            @click="editor.chain().focus().addRowAfter().run()"
            :disabled="!editor.can().addRowAfter()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-row-plus-after"
            />
          </button>
          <button
            type="button"
            @click="editor.chain().focus().deleteRow().run()"
            :disabled="!editor.can().deleteRow()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-row-remove"
            />
          </button>
          <button
            type="button"
            @click="editor.chain().focus().deleteTable().run()"
            :disabled="!editor.can().deleteTable()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-remove"
            />
          </button>
          <button
            type="button"
            @click="editor.chain().focus().mergeCells().run()"
            :disabled="!editor.can().mergeCells()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-merge-cells"
            />
          </button>
        </div>
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

import Table from '@tiptap/extension-table';
import TableCell from '@tiptap/extension-table-cell';
import TableHeader from '@tiptap/extension-table-header';
import TableRow from '@tiptap/extension-table-row';
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
      default: '<em>enunciado</em> <br> A) <br> B) <br> C) <br> D) <br> E)',
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
      extensions: [
        StarterKit,
        Underline,
        Image,
        Table.configure({
          resizable: true,
          lastColumnResizable: true,
        }),
        TableRow,
        TableHeader,
        TableCell,
      ],
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

<style>
/* Table-specific styling */
.ProseMirror {
  table {
    /* @apply table-auto; */
    border-collapse: collapse;
    margin: 0;
    max-width: 100%;
    width: 10%;

    td,
    th {
      @apply border-black border text-center font-normal;
      vertical-align: center;
      box-sizing: border-box;
      position: relative;
    }

    .selectedCell:after {
      z-index: 2;
      position: absolute;
      content: "";
      left: 0; right: 0; top: 0; bottom: 0;
      background: rgba(200, 200, 255, 0.4);
      pointer-events: none;
    }

    .column-resize-handle {
      position: absolute;
      right: -2px;
      top: 0;
      bottom: -2px;
      width: 4px;
      background-color: #adf;
      pointer-events: none;
    }
  }
}
</style>
