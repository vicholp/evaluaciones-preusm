<template>
  <div>
    <input
      type="hidden"
      v-model="value"
      :name="name"
    >
    <div ref="editor" />
  </div>
</template>

<script>
import Quill from 'quill';
import Delta from 'quill-delta';
import 'quill/dist/quill.snow.css';

import katex from 'katex';
import 'katex/dist/katex.min.css';

export default {
  props: {
    options: {
      type: Object,
      default: () => ({}),
    },
    name: {
      type: String,
      default: 'quilljs',
    },
    startValue: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      editor: null,
      value: '',
    };
  },
  mounted() {
    window.katex = katex;
    this.editor = new Quill(this.$refs.editor, {
      theme: 'snow',
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline', 'strike'],
          ['blockquote', 'code-block'],
          [{ 'header': 1 }, { 'header': 2 }],
          [{ 'list': 'ordered' }, { 'list': 'bullet' }],
          [{ 'script': 'sub' }, { 'script': 'super' }],
          [{ 'indent': '-1' }, { 'indent': '+1' }],
          [{ 'direction': 'rtl' }],
          [{ 'size': ['small', false, 'large', 'huge'] }],
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'font': [] }],
          [{ 'align': [] }],
          ['clean'],
          ['formula', 'image', 'video'],
        ],
      },
      ...this.options,
    });
    this.editor.on('text-change', this.onTextChange);

    if (this.startValue) {
      // this.editor.setContents(this.editor.clipboard.convert(this.startValue));
      // this.value = this.editor.root.innerHTML;
    }
  },
  methods: {
    onTextChange() {
      this.value = this.editor.root.innerHTML;
    },
  },
};
</script>
