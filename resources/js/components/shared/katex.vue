<template>
  <span
    ref="katexElement"
    v-html="katexHtml"
  />
</template>
<script>

import katex from 'katex';
import 'katex/dist/katex.min.css';

export default {
  props: {
    expression: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      katexHtml: '',
    };
  },
  watch: {
    expression() {
      this.katexHtml = katex.renderToString(this.expression, {
      });
    },
  },
};
</script>


