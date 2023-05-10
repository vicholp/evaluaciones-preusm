<template>
  <span
    ref="katexElement"
    class="inline-block my-3"
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
        displayMode: true,
      });
    },
  },
};
</script>
<style>
  .katex-display {
    @apply m-0;
  }
  .katex {
    @apply m-0;
  }
  .katex-html {
    @apply m-0;
  }
</style>


