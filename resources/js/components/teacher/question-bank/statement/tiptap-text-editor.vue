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
            :disabled="!editor.can().liftListItem('listItem')"
            @click="editor.chain().focus().liftListItem('listItem').run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:format-indent-decrease"
            />
          </button>
          <button
            type="button"
            :disabled="!editor.can().sinkListItem('listItem')"
            @click="editor.chain().focus().sinkListItem('listItem').run()"
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
            :disabled="!editor.can().addColumnBefore()"
            @click="editor.chain().focus().addColumnBefore().run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-column-plus-before"
            />
          </button>
          <button
            type="button"
            :disabled="!editor.can().addColumnAfter()"
            @click="editor.chain().focus().addColumnAfter().run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-column-plus-after"
            />
          </button>
          <button
            type="button"
            :disabled="!editor.can().deleteColumn()"
            @click="editor.chain().focus().deleteColumn().run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-column-remove"
            />
          </button>
          <button
            type="button"
            :disabled="!editor.can().addRowBefore()"
            @click="editor.chain().focus().addRowBefore().run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-row-plus-before"
            />
          </button>
          <button
            type="button"
            :disabled="!editor.can().addRowAfter()"
            @click="editor.chain().focus().addRowAfter().run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-row-plus-after"
            />
          </button>
          <button
            type="button"
            :disabled="!editor.can().deleteRow()"
            @click="editor.chain().focus().deleteRow().run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-row-remove"
            />
          </button>
          <button
            type="button"
            :disabled="!editor.can().deleteTable()"
            @click="editor.chain().focus().deleteTable().run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-remove"
            />
          </button>
          <button
            type="button"
            :disabled="!editor.can().mergeCells()"
            @click="editor.chain().focus().mergeCells().run()"
          >
            <span
              class="iconify text-2xl"
              data-icon="mdi:table-merge-cells"
            />
          </button>
        </div>
      </div>
      <div
        v-show="editor.isActive('customImage')"
        class="flex flex-row border-b pb-2 px-3"
      >
        <div class="flex flex-row gap-2">
          <span
            class="iconify text-2xl"
            data-icon="mdi:image"
          />
          <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />

          <button
            type="button"
            class="text-sm"
            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {size: 'small'})}"
            @click="editor.chain().focus().setImage({ size: 'small' }).run()"
          >
            Small
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {size: 'medium'})}"
            @click="editor.chain().focus().setImage({ size: 'medium' }).run()"
          >
            Medium
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {size: 'large'})}"
            @click="editor.chain().focus().setImage({ size: 'large' }).run()"
          >
            Large
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {size: 'original'})}"
            @click="editor.chain().focus().setImage({ size: 'original' }).run()"
          >
            Original
          </button>
          <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />

          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {float: 'left'})}"
            @click="editor.chain().focus().setImage({ float: 'left' }).run()"
          >
            Left
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {float: 'center'})}"
            @click="editor.chain().focus().setImage({ float: 'center' }).run()"
          >
            Center
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {float: 'right'})}"
            @click="editor.chain().focus().setImage({ float: 'right' }).run()"
          >
            Right
          </button>
        </div>
      </div>
    </div>
    <editor-content
      class="pt-3"
      :editor="editor"
    />
    <input
      v-model="html"
      type="hidden"
      :name="name"
    >
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
          class: 'prose dark:prose-invert m-3 focus:outline-none font-serif',
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

    window.TipTapEditor = this.editor;
  },
  beforeUnmount() {
    this.editor.destroy();
  },
};
</script>

<style>


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
  .custom-image-small {
        max-width: 25%;
    }
    .custom-image-medium {
        max-width: 50%;
    }
    .custom-image-large {
        max-width: 100%;
    }
    .custom-image-original {
        max-width: 100%;
    }

    .custom-image-float-left {
        margin-right: auto;
        display: block;
    }
    .custom-image-float-center {
        margin-left: auto;
        margin-right: auto;
        display: block;
    }

    img {
        width: 100%;
        height: auto;
        &.ProseMirror-selectednode {
            outline: 3px solid #68cef8;
        }
    }
}
</style>
