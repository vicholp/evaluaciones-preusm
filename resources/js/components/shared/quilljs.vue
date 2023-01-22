<template>
  <div ref="editor" />
</template>

<script>
import Quill from 'quill';
import Delta from 'quill-delta';
import 'quill/dist/quill.snow.css';

export default {
  props: {
    value: {
      type: String,
      default: '',
    },
    options: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      editor: null,
    };
  },
  mounted() {
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
        ],
      },
      ...this.options,
    });
    this.editor.on('text-change', this.onTextChange);
    this.editor.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => {
      const ops = [];
      delta.ops.forEach(op => {
        if (op.insert && op.insert.image) {
          const src = op.insert.image;
          ops.push({
            insert: {
              image: src,
            },
          });
        } else {
          ops.push(op);
        }
      });

      return new Delta(ops);
    });
  },
  watch: {
    value() {
      if (this.editor) {
        this.editor.setContents(this.editor.clipboard.convert(this.value));
      }
    },
  },
  methods: {
    onTextChange() {
      this.$emit('input', this.editor.root.innerHTML);
    },
  },
};
</script>
