<template>
  <div>
    <VueMultiselect
      v-model="selected"
      :options="tags"
      :multiple="true"
      track-by="id"
      label="name"
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
    value: {
      type: Array,
      default: () => [],
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
    this.selected = this.value;
  },
  watch: {
    selected() {
      this.selectedJson = JSON.stringify(this.selected.map(e => e.id));
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
