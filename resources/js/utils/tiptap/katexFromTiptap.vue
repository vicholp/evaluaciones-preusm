<template>
  <node-view-wrapper
    class="p-1"
    :class="{'border border-blue-500 rounded': selected }"
    as="span"
  >
    <katex :expression="expression" />
  </node-view-wrapper>
</template>
<script>
import { nodeViewProps, NodeViewWrapper } from '@tiptap/vue-3';

export default {
  components: {
    NodeViewWrapper,
  },
  props: nodeViewProps,
  data() {
    return {
      expression: '',
    };
  },
  computed: {
    formula() {
      return this.node.attrs.formula;
    },
  },
  watch: {
    formula() {
      this.expression = this.node.attrs.formula;
    },

  },
  mounted() {
    this.expression = this.node.attrs.formula;
  },
};
</script>


