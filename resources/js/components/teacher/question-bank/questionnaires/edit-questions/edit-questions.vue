<template>
  <div class="grid grid-cols-12 gap-3">
    <input
      v-model="selectedQuestionsJson"
      type="text"
      name="questions"
      hidden
    >
    <div class="col-span-12">
      <div class="bg-white rounded shadow dark:bg-gray-800 text-black dark:text-white dark:text-opacity-80 text-opacity-80 dark:shadow-none p-6">
        <div class="border-b pb-5">
          <filters
            :initial-filters="filters"
            @update-filters="updateFilters"
          />
        </div>
        <div class="flex flex-col divide-y divide-black dark:divide-white divide-opacity-5 dark:divide-opacity-5">
          <not-added-items
            :questions="questions"
            :added-questions="selectedQuestionParents"
            :pagination="pagination.questions"
            @page-changed="goToPageQuestions"
            @add-or-remove-question="addOrRemoveQuestion"
          />
        </div>
      </div>
    </div>
  </div>
  <div class="col-span-12">
    <div class="bg-white rounded shadow dark:bg-gray-800 text-black dark:text-white dark:text-opacity-80 text-opacity-80 dark:shadow-none p-6">
      <added-items
        :questions="selectedQuestions"
        @add-or-remove-question="addOrRemoveQuestion"
        @sorted-questions="sortedQuestions"
      />
    </div>
  </div>
</template>
<script>

import questionsApi from '../../../../../api/teacher/question-bank/questions.js';
import questionnairesApi from '../../../../../api/teacher/question-bank/questionnaire-prototypes.js';
import notAddedItems from './not-added-items.vue';
import filters from './filters.vue';
import addedItems from './added-items.vue';

export default {
  components: {
    notAddedItems,
    filters,
    addedItems,
  },
  props: {
    questionnaireId: {
      type: Number,
      required: true,
    },
    subjectId: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      questions: [],

      pagination: {
        questions: {},
      },

      selectedQuestions: [], // array of QuestionPrototypeVersion
      selectedQuestionParents: [], // array of QuestionPrototype

      selectedQuestionsJson: '',

      indexes: {},

      filters: {},
    };
  },
  created() {
    this.filters.whereSubjectId = this.subjectId;
    this.filters.orderBy = {
      column: 'updated_at',
      direction: 'desc',
    };
    this.filters.whereInQuestionnairePrototype = null;
  },
  async beforeMount() {
    let questionnaire = (await questionnairesApi.show(this.questionnaireId, {
      'withLatest': true,
      'withLatestItemsForEdit': true,
    })).data;

    this.selectedQuestions = questionnaire.latest.itemsForEdit;

    this.selectedQuestions.forEach((question) => {
      this.selectedQuestionParents.push(question.parent.id);
    });

    this.getQuestions();
  },
  methods: {
    goToPageQuestions(page) {
      this.filters.page = page;
      this.getQuestions();
    },
    goToPage(page) {
      this.filters.page = page;
    },
    async getQuestions() {
      let data = (await questionsApi.index({
        ...this.filters,
        'withLatest': true,
        'withTags': true,
        'withTagsTagGroup': true,
      })).data;

      this.questions = data.data;

      this.pagination.questions = data.meta;
    },

    updateFilters(filters) {
      this.filters = filters;
      this.getQuestions();
    },

    addOrRemoveQuestion(question) {
      // question is a QuestionPrototype
      let questionIndex = this.selectedQuestions.findIndex(e => e.parent.id === question.id);

      if (questionIndex !== -1) {
        this.selectedQuestions.splice(questionIndex, 1);
        this.selectedQuestionParents.splice(this.selectedQuestionParents.indexOf(question.id), 1);

        this.refreshJson();

        return;
      }

      this.selectedQuestions.push({
        ...question.latest,
        'parent': question,
      });

      this.selectedQuestionParents.push(question.id);

      this.refreshJson();
    },
    refreshJson() {
      this.selectedQuestionsJson = JSON.stringify(this.selectedQuestions.map(e => e.id));

      let questions = 0;

      this.selectedQuestions.forEach(question => {
        questions += 1;
        this.indexes[question.parent.id] = questions;
      });
    },
    sortedQuestions(questions) {
      this.selectedQuestions = questions;
      this.refreshJson();
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
