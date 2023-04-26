<template>
  <div class="w-[640px]">
    <editor-content
      :editor="editor"
    />
  </div>
</template>
<script>

import { EditorContent } from '@tiptap/vue-3';
import { Editor } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import Katex from '../../utils/tiptap/CustomKatex';
import CustomImage from '../../utils/tiptap/CustomImage';
import TextAlign from '@tiptap/extension-text-align';

import '../../../css/tiptap.css';

const TEXT_MAX_LENGTH = 50;

export default {
  components: {
    EditorContent,
  },
  props: {
    initialContent: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      editor: null,
    };
  },
  created() {
    this.editor = new Editor({
      content: this.initialContent,
      extensions: [
        StarterKit,
        Katex,
        Underline,
        CustomImage.configure({
          allowBase64: true,
        }),
        TextAlign.configure({
          types: ['heading', 'paragraph', 'customKatex'],
        }),
      ],
      editorProps: {
        attributes: {
          class: 'prose dark:prose-invert focus:outline-none',
        },
      },
    });

    let html = this.editor.getHTML();
    let root = document.createElement('div');

    root.innerHTML = html;

    let images = root.querySelectorAll('img');
    images.forEach((image) => {
      image.remove();
    });

    let brs = root.querySelectorAll('br');
    brs.forEach((br) => {
      br.remove();
    });

    //select first element that is p or katex
    let p = root.querySelector('p:not(:empty)');

    let shortContent = p.innerHTML.substring(0, TEXT_MAX_LENGTH);

    if (p.innerHTML.length > TEXT_MAX_LENGTH) shortContent += '...';

    this.editor.commands.setContent(shortContent);

    this.editor.setEditable(false);
  },
  beforeUnmount() {
    this.editor.destroy();
  },
};
</script>
