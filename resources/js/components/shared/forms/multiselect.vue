<template>
  <div>
    <VueMultiselect
      v-model="selected"
      :options="tags"
      :taggable="true"
      :multiple="true"
    />
    <input
      v-model="selected"
      :name="name"
      hidden
    >
  </div>
</template>
<script>

import VueMultiselect from 'vue-multiselect';

export default {
  components: {
    VueMultiselect,
  },
  props: {
    name: {
      type: String,
      required: true,
    },
    options: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      selected: [],
      tags: this.options,
    };
  },
  methods: {
    addTag(newTag) {
      const tag = newTag;

      this.tags.push(tag);
      this.selected.push(tag);
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
