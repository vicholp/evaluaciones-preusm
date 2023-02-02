<template>
  <div>
    <VueMultiselect
      v-model="selected"
      :options="tags"
      :multiple="true"
      @tag="addTag"
    />
    <input
      v-model="selectedJson"
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
      tags: [],
      selectedJson: '',
    };
  },
  mounted() {
    this.tags = this.options;
  },
  watch: {
    selected() {
      this.selectedJson = JSON.stringify(this.selected);
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
