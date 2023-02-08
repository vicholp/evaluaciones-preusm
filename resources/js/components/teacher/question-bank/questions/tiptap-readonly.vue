<template>
  <div class="border rounded p-2 w-[640px]">
    <editor-content
      :editor="editor"
    />
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

export default {
  components: {
    EditorContent,
  },
  props: {
    initialContent: {
      type: String,
      required: true,
      default: '',
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
    this.editor.setEditable(false);
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
