<template>
  <div class="grid grid-cols-12 gap-3 items-center">
    <div class="col-span-3 flex flex-col gap-1 justify-center">
      <div>
        {{ $t('subject') }}
      </div>
      <select
        v-model="filters.whereSubjectId"
        class="rounded h-10 px-2 w-full
              focus:border-blue-500 focus:border-2 focus:ring-0
              disabled:text-opacity-60 disabled:text-white
              border-black border-opacity-20 border-1
              dark:border-white dark:border-opacity-10 dark:border-1
              bg-dark bg-opacity-10
              dark:bg-black dark:bg-opacity-30"
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
        {{ $t('questionnaire') }}
      </div>
      <select
        v-model="filters.whereInQuestionnairePrototype"
        class="rounded h-10 px-2 w-full
              focus:border-blue-500 focus:border-2 focus:ring-0
              disabled:text-opacity-60 disabled:text-white
              border-black border-opacity-20 border-1
              dark:border-white dark:border-opacity-10 dark:border-1
              bg-dark bg-opacity-10
              dark:bg-black dark:bg-opacity-30"
      >
        <option
          class="dark:bg-gray-900"
          :selected="filters.whereInQuestionnairePrototype == null"
          :value="null"
        >
          {{ $t('all') }}
        </option>
        <option
          v-for="questionnaire in questionnaires"
          :key="questionnaire.id"
          :value="questionnaire.id"
          class="dark:bg-gray-900"
          :selected="filters.whereInQuestionnairePrototype == questionnaire.id"
        >
          {{ questionnaire.name }}
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
      />
    </div>
    <div class="col-span-3 flex flex-col gap-1 justify-center">
      <div>
        {{ $t('sort by') }}
      </div>
      <select
        v-model="filters.orderBy"
        class="rounded h-10 px-2 w-full
              focus:border-blue-500 focus:border-2 focus:ring-0
              disabled:text-opacity-60 disabled:text-white
              border-black border-opacity-20 border-1
              dark:border-white dark:border-opacity-10 dark:border-1
              bg-dark bg-opacity-10
              dark:bg-black dark:bg-opacity-30"
      >
        <option
          v-for="option in ORDER_BY_FILTERS"
          :key="option.value"
          :value="option.value"
          class="dark:bg-gray-900"
        >
          {{ $t(option.label) }}
        </option>
      </select>
    </div>
  </div>
</template>
<script>

import questionnairesApi from '../../../../../api/teacher/question-bank/questionnaire-prototypes.js';
import subjectsApi from '../../../../../api/teacher/question-bank/subjects.js';
import tagsApi from '../../../../../api/teacher/question-bank/tags.js';
import VueMultiselect from 'vue-multiselect';

const ORDER_BY_FILTERS = [
  {
    value: {
      column: 'id',
      direction: 'asc',
    },
    label: 'default',
  },
  {
    value: {
      column: 'created_at',
      direction: 'desc',
    },
    label: 'last created',
  },
  {
    value: {
      column: 'updated_at',
      direction: 'desc',
    },
    label: 'last updated',
  },
];

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
      questionnaires: [],
      ORDER_BY_FILTERS,
    };
  },
  watch: {
    'filters.whereSubjectId'() {
      this.emitUpdateFilters();

      this.getTags();

      this.filters.whereInQuestionnairePrototype = null;
      this.getQuestionnaires();
    },
    'filters.whereInQuestionnairePrototype'() {
      this.emitUpdateFilters();
    },
    'filters.whereTags'() {
      this.emitUpdateFilters();
    },
    'filters.orderBy'() {
      this.emitUpdateFilters();
    },
    selectedTags() {
      this.filters.whereTags = this.selectedTags.map(e => e.id);
    },
  },
  beforeMount() {
    this.getSubjects();
    this.getQuestionnaires();
    this.getTags();
  },
  methods: {
    emitUpdateFilters() {
      this.$emit('update-filters', {
        ...this.filters,
      });
    },
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
    async getQuestionnaires() {
      this.questionnaires = (await questionnairesApi.index({
        'whereSubjectId': this.filters.whereSubjectId,
      })).data;
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

