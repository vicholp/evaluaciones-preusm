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
        <h3 class="font-medium">
          agregar preguntas
        </h3>
        <div class="mb-4" />
        <div class="flex flex-col gap-5">
          <div class="grid grid-cols-12 gap-5">
            <div class="flex flex-row gap-3 items-center col-span-6">
              <div>
                {{ $t('subject') }}
              </div>
              <select
                v-model="filters.whereSubjectId"
                class="col-span-8 rounded h-10 w-full dark:bg-white dark:bg-opacity-5 border-black border-opacity-10"
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
            <div class="flex gap-3 items-center col-span-6">
              <div>
                {{ $t('tags') }}
              </div>
              <VueMultiselect
                v-model="selectedTags"
                :options="tags"
                :multiple="true"
                track-by="id"
                label="name"
                class="w-60 min-w-min"
              />
            </div>
          </div>
          <div class="flex flex-col divide-y divide-black dark:divide-white divide-opacity-5 dark:divide-opacity-5">
            <div
              v-for="question of questions"
              :key="question.id"
              class="flex flex-col gap-3 py-4"
            >
              <div class="flex flex-col gap-3">
                <div class="flex gap-3">
                  <div class="flex items-center">
                    {{ question.latest.name }}
                  </div>
                  <div class="ml-auto" />
                  <div class="flex gap-2">
                    <button class="rounded px-2 py-1 bg-black bg-opacity-5" type="button" @click=" showQuestionWhenAdding[question.id] = !showQuestionWhenAdding[question.id];">
                      {{ showQuestionWhenAdding[question.id] ? 'ocultar' : 'mostrar' }} texto
                    </button>
                    <button
                      class="rounded px-2 py-1 bg-black bg-opacity-5" type="button"
                      @click="addQuestionOrRemove(question)"
                    >
                      {{ selectedQuestionParents.includes(question.id) ? 'quitar' : 'agregar' }}
                    </button>
                  </div>
                </div>
                <div
                  v-if="showQuestionWhenAdding[question.id]"
                  class="flex flex-col items-center"
                >
                  <teacher-question-bank-questions-tiptap
                    :editable="false"
                    :initial-content="question.latest.body"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-row gap-2 justify-center">
          <button
            v-for="page in questionPagination.lastPage"
            :key="page"
            :class="`
              rounded px-2 py-1 bg-black
              ${questionPagination.currentPage == page ? 'bg-opacity-30' : 'bg-opacity-5'}
            `"
            type="button"
            @click="goToPage(page)"
          >
            {{ page }}
          </button>
        </div>
      </div>
    </div>
    <div class="col-span-12">
      <div class="bg-white rounded shadow dark:bg-gray-800 text-black dark:text-white dark:text-opacity-80 text-opacity-80 dark:shadow-none p-6">
        <h3 class="font-medium">
          preguntas
        </h3>
        <div class="mb-4" />
        <div>
          <draggable
            :list="selectedQuestions"
            item-key="id"
            class="flex flex-col divide-y divide-black dark:divide-white divide-opacity-5 dark:divide-opacity-5"
            @start="drag=true"
            @end="drag=false; checkMove()"
          >
            <template #item="{element: question, index: questionIndex}">
              <div class="flex flex-col gap-3 py-4  ">
                <div class="flex flex-col gap-3">
                  <div class="flex gap-3">
                    <div class="flex items-center">
                      {{ questionIndex + 1 }} {{ question.name }}
                    </div>
                    <div class="ml-auto" />
                    <div class="flex gap-2">
                      <button class="rounded px-2 py-1 bg-black bg-opacity-5" type="button" @click=" showQuestionAdded[question.parent.id] = !showQuestionAdded[question.parent.id];">
                        {{ showQuestionAdded[question.parent.id] ? 'ocultar' : 'mostrar' }} texto
                      </button>
                      <button
                        class="rounded px-2 py-1 bg-black bg-opacity-5" type="button"
                        @click="addQuestionOrRemove({ ...question.parent, 'latest': {...question} })"
                      >
                        {{ selectedQuestionParents.includes(question.parent.id) ? 'quitar' : 'agregar' }}
                      </button>
                    </div>
                  </div>
                  <div
                    v-if="showQuestionAdded[question.parent.id]"
                    class="flex flex-col items-center"
                  >
                    <teacher-question-bank-questions-tiptap
                      :editable="false"
                      :initial-content="question.body"
                    />
                  </div>
                </div>
              </div>
            </template>
          </draggable>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import draggable from 'vuedraggable';
import VueMultiselect from 'vue-multiselect';
import questionsApi from '../../../../api/teacher/question-bank/questions.js';
import tagsApi from '../../../../api/teacher/question-bank/tags.js';
import subjectsApi from '../../../../api/teacher/question-bank/subjects.js';
import questionnairesApi from '../../../../api/teacher/question-bank/questionnaire-prototypes.js';

export default {
  components: {
    VueMultiselect,
    draggable,
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

      questionPagination: {
        from: 0,
        to: 0,
        lastPage: 0,
        perPage: 0,
        total: 0,
        currentPage: 1,
      },

      tags: [],
      subjects: [],

      showStatementWhenAdding: [],
      showStatementQuestionsWhenAdding: [],
      showQuestionWhenAdding: [],

      showQuestionAdded: [],

      selectedQuestions: [],

      selectedQuestionParents: [],


      selectedQuestionsJson: '',

      filters: {},
      selectedTags: [],
      myArray: [],

      indexes: {},
    };
  },
  watch: {
    filters: {
      handler() {
        this.getQuestions();
      },
      deep: true,
    },
    selectedTags() {
      this.filters.whereQuestionTags = this.selectedTags.map(e => e.id);
    },
  },
  async mounted() {
    let questionnaire = (await questionnairesApi.show(this.questionnaireId, {
      'withLatest': true,
      'withLatestItemsForEdit': true,
    })).data;

    this.selectedQuestions = questionnaire.latest.itemsForEdit;

    this.selectedQuestions.forEach((question) => {
      this.selectedQuestionParents.push(question.parent.id);
    });

    this.filters.whereSubjectId = this.subjectId;

    this.subjects = (await subjectsApi.index({
      'relatedTo': this.subjectId,
    })).data;
    this.tags = (await tagsApi.index({
      'whereSubjectId': this.filters.whereSubjectId,
      'orWhereSubjectIdNull': true,
    })).data;
  },
  methods: {
    goToPage(page) {
      this.filters.page = page;
    },
    async getQuestions() {
      let data = (await questionsApi.index({
        ...this.filters,
        'withLatest': true,
        'withTags': true,
      })).data;

      this.questions = data.data;

      this.questionPagination = data.meta;
    },
    addQuestionOrRemove(question) {
      let questionIndex = this.selectedQuestions.findIndex(e => e.id === question.latest.id);

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
    checkMove() {
      this.refreshJson();
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
