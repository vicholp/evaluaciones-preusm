<template>
  <div class="grid grid-cols-12 gap-3 items-center">
    <div class="col-span-3 flex flex-col gap-1 justify-center">
      <div>
        {{ $t('subject') }}
      </div>
      <select
        v-model="filters.whereSubjectId"
      >
        <option
          v-for="subject in subjects"
          :key="subject.id"
          :value="subject.id"
          class="dark:bg-gray-900"
          :selected="filters.whereSubjectId == subject.id"
        >
          {{ subject.name }}
        </option>
      </select>
    </div>
    <div class="col-span-3 flex flex-col gap-1 justify-center">
      <div>
        {{ $t('tags') }}
      </div>
      <VueMultiselect
        v-model="selectedTags"
        :options="tags"
        :multiple="true"
        track-by="id"
        label="name"
        class=""
      />
    </div>
  </div>
</template>
<script>

import subjectsApi from '../../../../../api/teacher/question-bank/subjects.js';
import tagsApi from '../../../../../api/teacher/question-bank/tags.js';
import VueMultiselect from 'vue-multiselect';

export default {
  components: {
    VueMultiselect,
  },
  props: {
    initialFilters: {
      type: Object,
      required: true,
    },
  },
  emits: [
    'update-filters',
  ],
  data() {
    return {
      selectedTags: null,
      filters: this.initialFilters,
      tags: [],
      subjects: [],
    };
  },
  watch: {
    filters: {
      handler() {
        this.$emit('update-filters', {
          ...this.filters,
        });

        this.getTags();
      },
      deep: true,
    },
    selectedTags() {
      this.filters.whereTags = this.selectedTags.map(e => e.id);
    },
  },
  beforeMount() {
    this.getSubjects();
    this.getTags();
  },
  methods: {
    async getSubjects() {
      this.subjects = (await subjectsApi.index({
        'relatedTo': this.filters.whereSubjectId,
        'forQuestions': true,
      })).data;
    },
    async getTags() {
      this.tags = (await tagsApi.index({
        'whereSubjectId': this.filters.whereSubjectId,
        'orWhereSubjectIdNull': true,
        'orWhereSubjectIdInParents': this.filters.whereSubjectId,
        'withTagGroup': true,
      })).data;
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

