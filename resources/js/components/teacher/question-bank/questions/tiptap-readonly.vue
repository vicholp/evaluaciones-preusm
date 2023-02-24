<template>
  <div class="border rounded p-2 w-[640px]">
    <editor-content
      :editor="editor"
    />
  </div>
</template>
<script>

import { EditorContent } from '@tiptap/vue-3';
import Table from '@tiptap/extension-table';
import TableCell from '@tiptap/extension-table-cell';
import TableHeader from '@tiptap/extension-table-header';
import TableRow from '@tiptap/extension-table-row';
import { Editor } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import CustomImage from '../../../../utils/tiptap/CustomImage';

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
        CustomImage.configure({
          allowBase64: true,
          HTMLAttributes: {
            class: 'custom-image',
          },
        }),
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
        handleDOMEvents: {
          paste(view, event) {
            const hasFiles =
              event.clipboardData &&
              event.clipboardData.files &&
              event.clipboardData.files.length;

            if (!hasFiles) {
              return;
            }

            const images = Array.from(
              event.clipboardData.files,
            ).filter(file => /image/i.test(file.type));

            if (images.length === 0) {
              return;
            }

            event.preventDefault();

            images.forEach(image => {
              const reader = new FileReader();

              reader.addEventListener('load', () => {
                const src = reader.result.toString().replace(/^data:(.*,)?/, '');

                const node = view.state.schema.nodes.customImage.create({
                  src: `data:image/png;base64,${src}`,
                });
                const transaction = view.state.tr.replaceSelectionWith(node);
                view.dispatch(transaction);
              }, false);

              reader.readAsDataURL(image);
            });
          },
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
