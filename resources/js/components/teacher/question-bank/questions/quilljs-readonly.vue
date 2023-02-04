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
      value: this.startValue,
    };
  },
  mounted() {
    window.katex = katex;
    this.editor = new Quill(this.$refs.editor, {
      theme: 'snow',
      modules: {
        toolbar: [

        ],
      },
      ...this.options,
    });

    if (this.value) {
      this.editor.setContents(this.editor.clipboard.convert(this.value));
    }
    debugger;
    // this.editor.enable(false);
  },
};
</script>
