<template>
  <node-view-wrapper
    class="p-1"
    :class="{'border border-blue-500 rounded': selected }"
    as="span"
  >
    <span
      ref="katexElement"
      class="katex-element"
      v-html="katexHtml"
    />
  </node-view-wrapper>
</template>
<script>

import katex from 'katex';
import 'katex/dist/katex.min.css';

import { nodeViewProps, NodeViewWrapper } from '@tiptap/vue-3';

export default {
  components: {
    NodeViewWrapper,
  },
  props: nodeViewProps,
  data() {
    return {
      katexHtml: '',
    };
  },
  computed: {
    formula() {
      return this.node.attrs.formula;
    },
  },
  watch: {
    formula() {
      this.katexHtml = katex.renderToString(this.node.attrs.formula);
    },
    // watch for this.node.attrs.formula changes

  },
  mounted() {
    this.katexHtml = katex.renderToString(this.node.attrs.formula);
  },
};
</script>


