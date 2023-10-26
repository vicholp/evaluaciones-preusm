<template>
  <div :class="withStyle ? 'border rounded p-3 flex flex-col w-[640px]' : ''">
    <div
      v-if="editable"
      class="flex flex-col gap-2"
    >
      <!-- Default tools -->
      <tiptap-button-line>
        <div class="flex flex-row gap-2">
          <tiptap-button
            icon="mdi:undo"
            @do="editor.chain().focus().undo().run()"
          />
          <tiptap-button
            icon="mdi:redo"
            @do="editor.chain().focus().redo().run()"
          />
        </div>
        <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />
        <tiptap-button-group>
          <tiptap-button
            icon="mdi:format-align-left"
            :active="editor.isActive({ textAlign: 'left' })"
            @do="editor.chain().focus().setTextAlign('left').run()"
          />
          <tiptap-button
            icon="mdi:format-align-center"
            :active="editor.isActive({ textAlign: 'center' })"
            @do="editor.chain().focus().setTextAlign('center').run()"
          />
          <tiptap-button
            icon="mdi:format-align-right"
            :active="editor.isActive({ textAlign: 'right' })"
            @do="editor.chain().focus().setTextAlign('right').run()"
          />
          <tiptap-button
            icon="mdi:format-align-justify"
            :active="editor.isActive({ textAlign: 'justify' })"
            @do="editor.chain().focus().setTextAlign('justify').run()"
          />
        </tiptap-button-group>
        <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />
        <tiptap-button-group>
          <tiptap-button
            icon="mdi:format-bold"
            :active="editor.isActive('bold' )"
            @do="editor.chain().focus().toggleBold().run()"
          />
          <tiptap-button
            icon="mdi:format-italic"
            :active="editor.isActive('italic')"
            @do="editor.chain().focus().toggleItalic().run()"
          />
          <tiptap-button
            icon="mdi:format-strikethrough"
            :active="editor.isActive('strike' )"
            @do="editor.chain().focus().toggleStrike().run()"
          />
          <tiptap-button
            icon="mdi:format-underline"
            :active="editor.isActive('underline' )"
            @do="editor.chain().focus().toggleUnderline().run()"
          />
          <tiptap-button
            icon="mdi:format-superscript"
            :active="editor.isActive('superscript' )"
            @do="editor.chain().focus().toggleSuperscript().run()"
          />
          <tiptap-button
            icon="mdi:format-subscript"
            :active="editor.isActive('subscript' )"
            @do="editor.chain().focus().toggleSubscript().run()"
          />
        </tiptap-button-group>
        <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />
        <tiptap-button-group>
          <tiptap-button
            icon="mdi:format-list-bulleted"
            :active="editor.isActive('bulletList' )"
            @do="editor.chain().focus().toggleBulletList().run()"
          />
          <tiptap-button
            icon="mdi:format-indent-decrease"
            :disabled="!editor.can().liftListItem('listItem')"
            @do="editor.chain().focus().liftListItem('listItem').run()"
          />
          <tiptap-button
            icon="mdi:format-indent-increase"
            :disabled="!editor.can().sinkListItem('listItem')"
            @do="editor.chain().focus().sinkListItem('listItem').run()"
          />
        </tiptap-button-group>
        <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />
        <tiptap-button-group>
          <tiptap-button
            icon="mdi:table"
            @do="editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()"
          />
        </tiptap-button-group>
        <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />
        <tiptap-button-group>
          <tiptap-button
            icon="mdi:calculator-variant-outline"
            @do="editor.chain().focus().setKatex({ 'formula': katexInput }).run()"
          />
        </tiptap-button-group>
      </tiptap-button-line>

      <!-- Text tools -->
      <tiptap-button-line
        v-if="textTools"
      >
        <div class="flex items-center gap-3">
          <select
            v-model="headingLevel"
            class="rounded h-8 pr-10 py-0"
            @input="toggleHeading($event.target.value)"
          >
            <option value="0">
              Texto normal
            </option>
            <option value="1">
              Titulo
            </option>
            <option value="2">
              Subtitulo
            </option>
            <option value="3">
              Subsubtitulo
            </option>
          </select>
        </div>
      </tiptap-button-line>

      <!-- Table tools -->
      <tiptap-button-line
        v-show="editor.isActive('table')"
      >
        <div class="flex flex-row gap-2">
          <span
            class="iconify text-2xl"
            data-icon="mdi:table"
          />
          <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />

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
      </tiptap-button-line>

      <!-- Image tools -->
      <tiptap-button-line
        v-show="editor.isActive('customImage')"
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
            Minimo
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {size: 'medium'})}"
            @click="editor.chain().focus().setImage({ size: 'medium' }).run()"
          >
            50%
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {size: 'large'})}"
            @click="editor.chain().focus().setImage({ size: 'large' }).run()"
          >
            100%
          </button>
          <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />

          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {float: 'left'})}"
            @click="editor.chain().focus().setImage({ float: 'left' }).run()"
          >
            Izquierda
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {float: 'none'})}"
            @click="editor.chain().focus().setImage({ float: 'none' }).run()"
          >
            Junto al texto
          </button>
          <button
            type="button"
            class="text-sm"

            :class="{'bg-black bg-opacity-10 rounded': editor.isActive('customImage', {float: 'right'})}"
            @click="editor.chain().focus().setImage({ float: 'right' }).run()"
          >
            Derecha
          </button>
        </div>
      </tiptap-button-line>

      <!-- Katex -->
      <tiptap-button-line
        v-show="editor.isActive('customKatex')"
      >
        <div class="flex flex-row gap-2 w-full">
          <span
            class="iconify text-4xl my-auto"
            data-icon="mdi:calculator-variant-outline"
          />
          <div class="w-[1px] h-100 bg-black bg-opacity-10 mx-3" />
          <div class="flex flex-col gap-3 items-center w-full">
            <input
              v-model="katexInput"
              type="text"
              class="rounded w-full dark:bg-white dark:text-white dark:bg-opacity-5"
              @change="editor.chain().setKatex({ 'formula': katexInput }).run()"
            >
            <katex
              :expression="katexInput"
              class="border rounded w-full h-16 flex items-center p-3"
            />
          </div>
          <button
            type="button"
            @click="editor.chain().focus().setKatex({ 'formula': katexInput }).run()"
          >
            OK
          </button>
        </div>
      </tiptap-button-line>
    </div>
    <editor-content
      :class="withStyle && editable ? 'pt-3' : ''"
      :editor="editor"
    />
    <input
      v-if="editable"
      v-model="html"
      type="hidden"
      :name="name"
      :required="required"
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
import CustomImage from '../../utils/tiptap/CustomImage';
import Katex from '../../utils/tiptap/CustomKatex';
import TextAlign from '@tiptap/extension-text-align';
import Superscript from '@tiptap/extension-superscript';
import Subscript from '@tiptap/extension-subscript';

import '../../../css/tiptap.css';

import questionPrototypeVersionApi from '../../api/teacher/question-bank/question-prototype-versions';

import TiptapButton from './button.vue';
import TiptapButtonGroup from './button-group.vue';
import TiptapButtonLine from './button-line.vue';

export default {
  components: {
    EditorContent,
    TiptapButton,
    TiptapButtonGroup,
    TiptapButtonLine,
  },
  props: {
    /**
     * The id of the question prototype version to get the content from
     * This assumes you are editing a question prototype version
     */
    versionId: {
      type: Number,
      required: false,
      default: null,
    },

    /**
     * The attribute of the api respose to get the content from, if versionId is set
     */
    attribute: {
      type: String,
      required: false,
      default: 'body',
    },

    /**
     * The initial content of the editor, if versionId is not set
     */
    content: {
      type: String,
      required: false,
      default: null,
    },

    /**
     * The name of the input text
     */
    name: {
      type: String,
      required: false,
      default: 'null',
    },

    /**
     * If the editor should be editable and the tools should be shown
     */
    editable: {
      type: Boolean,
      required: false,
      default: true,
    },

    /**
     * Show editor with margin and padding
     * Useful for showing the content for preview
     */
    withStyle: {
      type: Boolean,
      required: false,
      default: true,
    },

    /**
     * If text tools should be shown
     */
    textTools: {
      type: Boolean,
      required: false,
      default: false,
    },

    /**
     * If the input is required
     */
    required: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  data() {
    return {
      html: '', // The html to be sent to the server
      editor: null, // The editor instance
      katexInput: '', // The input of the katex formula
      initialContent: '', // The initial content to set the editor to
      headingLevel: '0', // The heading level of the text, 0 is normal text
    };
  },
  async created() {
    this.initialContent = "";

    if (this.versionId) {
      const version = (await questionPrototypeVersionApi.get(this.versionId)).data;
      this.initialContent = version[this.attribute];
    }

    if (this.content !== null) {
      this.initialContent = this.content;
    }

    this.editor = new Editor({
      content: this.initialContent,
      extensions: [
        StarterKit,
        TextAlign.configure({
          types: ['heading', 'paragraph', 'customKatex'],
        }),
        CustomImage.configure({
          allowBase64: true,
        }),
        Table.configure({
          resizable: true,
          lastColumnResizable: true,
        }),
        TableRow,
        Katex,
        Underline,
        TableHeader,
        TableCell,
        Superscript,
        Subscript,
      ],
      editorProps: {
        attributes: {
          class: `prose dark:prose-invert font-[Arial] text-black dark:text-white font-medium focus:outline-none ${this.withStyle ? 'm-3' : ''}`,
        },
        handleDOMEvents: {
          // keydown: (view, event) => {
          //   if (event.key === "Tab") {
          //     event.preventDefault();
          //     view.dispatch(view.state.tr.insertText("\t"));
          //     return true;
          //   }

          //   return false;
          // },
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

    if(this.editable) {
      this.html = this.editor.getHTML();

      this.editor.on('update', () => {
        this.html = this.editor.getHTML();
      });

      this.editor.on('selectionUpdate', () => {
        if (this.editor.isActive('customKatex')) {
          this.katexInput = this.editor.getAttributes('customKatex').formula;
        } else {
          this.katexInput = '';
        }
      });
    } else {
      this.editor.setEditable(false);
    }
  },
  beforeUnmount() {
    this.editor.destroy();
  },
  methods: {
    toggleHeading(value) {
      if (value === '0') {
        const value = this.editor.getAttributes('heading').level;

        this.editor.chain().focus().toggleHeading({
          level: parseInt(value),
        }).run();
      } else{
        this.editor.chain().focus().toggleHeading({
          level: parseInt(value),
        }).run();
      }
    },
  },
};
</script>
