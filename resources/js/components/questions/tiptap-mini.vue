<template>
  <div :class="`h-[28px] ${hasFrac ? 'mt-[-40px]' : ''}`">
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

import questionPrototypeVersionApi from '../../api/teacher/question-bank/question-prototype-versions';

const TEXT_MAX_LENGTH = 60;

export default {
  components: {
    EditorContent,
  },
  props: {
    versionId: {
      type: Number,
      required: false,
      default: null,
    },
    attribute: {
      type: String,
      required: false,
      default: 'body',
    },
    initialContent: {
      type: String,
      required: false,
      default: null,
    },
    length: {
      type: Number,
      required: false,
      default: TEXT_MAX_LENGTH,
    },
  },
  data() {
    return {
      editor: null,
      content: null,
      hasFrac: false,
    };
  },
  async created() {
    if (this.versionId) {
      const version = (await questionPrototypeVersionApi.get(this.versionId)).data;
      this.content = version[this.attribute];
    } else {
      this.content = this.initialContent;
    }

    this.editor = new Editor({
      content: this.content,
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

    let shortContent = p.innerHTML.substring(0, this.length);

    // if short context contain katex open tag, close it
    if (shortContent.includes('<katex')) {
      if (! shortContent.includes('</katex>')) {
        // clear all after
        shortContent = shortContent.substring(0, shortContent.indexOf('<katex'));
      }
    }

    if (p.innerHTML.length > this.length) shortContent += '...';

    this.editor.commands.setContent(shortContent);

    if (shortContent.includes('\\frac')) {
      this.hasFrac = true;
    }

    this.editor.setEditable(false);
  },
  beforeUnmount() {
    this.editor.destroy();
  },
};
</script>
