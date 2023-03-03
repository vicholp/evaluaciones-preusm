<template>
  <div class="grid grid-cols-12 gap-3">
    <input
      v-model="selectedStatementsJson"
      type="text"
      name="statements"
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
              v-for="statement of statements"
              :key="statement.id"
              class="flex flex-col gap-3 py-4"
            >
              <div class="flex flex-col gap-3">
                <div class="flex gap-3">
                  <div class="flex items-center">
                    {{ statement.name }}
                  </div>
                  <div class="ml-auto" />
                  <div class="flex gap-2">
                    <button class="rounded px-2 py-1 bg-black bg-opacity-5" type="button" @click=" showStatementWhenAdding[statement.id] = !showStatementWhenAdding[statement.id];">
                      {{ showStatementWhenAdding[statement.id] ? 'ocultar' : 'mostrar' }} texto
                    </button>
                    <button
                      class="rounded px-2 py-1 bg-black bg-opacity-5" type="button"
                      @click="showStatementQuestionsWhenAdding[statement.id] = !showStatementQuestionsWhenAdding[statement.id]"
                    >
                      {{ showStatementQuestionsWhenAdding[statement.id] ? 'ocultar' : 'mostrar' }} preguntas
                    </button>
                  </div>
                </div>
                <div
                  v-if="showStatementWhenAdding[statement.id]"
                  class="flex flex-col items-center"
                >
                  <teacher-question-bank-statement-tiptap-text-readonly
                    :initial-content="statement.body"
                  />
                </div>
              </div>
              <div
                v-if="showStatementQuestionsWhenAdding[statement.id]"
                class="flex flex-col gap-3 py-4 ml-4"
              >
                <div
                  v-for="question of statement.questions"
                  :key="question.id"
                  class="flex flex-col gap-3"
                >
                  <div class="flex gap-3">
                    <div>
                      {{ question.latest.name }}
                    </div>
                    <div class="ml-auto" />
                    <div class="flex flex-row gap-2">
                      <button
                        class="rounded px-2 py-1 bg-black bg-opacity-5" type="button"
                        @click="addQuestionOrRemove(statement, question)"
                      >
                        {{ selectedQuestions.includes(question.id) ? 'quitar' : 'agregar' }}
                      </button>
                      <button
                        class="rounded px-2 py-1 bg-black bg-opacity-5" type="button"
                        @click="showQuestionWhenAdding[question.id] = !showQuestionWhenAdding[question.id]"
                      >
                        {{ showQuestionWhenAdding[question.id] ? 'ocultar' : 'mostrar' }} pregunta
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
        </div>
        <div class="flex flex-row gap-2 justify-center">
          <button
            v-for="page in statementPagination.lastPage"
            :key="page"
            :class="`
              rounded px-2 py-1 bg-black
              ${statementPagination.currentPage == page ? 'bg-opacity-30' : 'bg-opacity-5'}
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
            :list="selectedStatements"
            item-key="id"
            class="flex flex-col divide-y divide-black dark:divide-white divide-opacity-5 dark:divide-opacity-5"
            @start="drag=true"
            @end="drag=false; checkMove()"
          >
            <template #item="{element: statement, index: statementIndex}">
              <div class="flex flex-col gap-3 py-4  ">
                <div class="flex flex-col gap-3">
                  <div class="flex gap-3">
                    <div class="flex items-center">
                      {{ $t('statement') }} {{ statementIndex+1 }}: {{ statement.name }}
                    </div>
                    <div class="ml-auto" />
                    <div class="flex gap-2">
                      <button class="rounded px-2 py-1 bg-black bg-opacity-5" type="button" @click=" showStatementAdded[statement.id] = !showStatementAdded[statement.id];">
                        {{ showStatementAdded[statement.id] ? 'ocultar' : 'mostrar' }} texto
                      </button>
                      <button
                        class="rounded px-2 py-1 bg-black bg-opacity-5" type="button"
                        @click="showStatementQuestionsAdded[statement.id] = !showStatementQuestionsAdded[statement.id]"
                      >
                        {{ showStatementQuestionsAdded[statement.id] ? 'ocultar' : 'mostrar' }} preguntas
                      </button>
                    </div>
                  </div>
                  <div
                    v-if="showStatementAdded[statement.id]"
                    class="flex flex-col items-center"
                  >
                    <teacher-question-bank-statement-tiptap-text-readonly
                      :initial-content="statement.body"
                    />
                  </div>
                </div>
                <div
                  v-if="showStatementQuestionsAdded[statement.id]"
                >
                  <draggable
                    :list="statement.questions"
                    item-key="id"
                    class="flex flex-col gap-3 py-4 ml-4"
                    @start="drag=true"
                    @end="drag=false; checkMove()"
                  >
                    <template #item="{element: question}">
                      <div
                        class="flex flex-col gap-3"
                      >
                        <div class="flex gap-3">
                          <div>
                            {{ indexes[question.parent.id] }} {{ question.name }}
                          </div>
                          <div class="ml-auto" />
                          <div class="flex flex-row gap-2">
                            <button
                              class="rounded px-2 py-1 bg-black bg-opacity-5" type="button"
                              @click="addQuestionOrRemove(statement, { ...question.parent, 'latest': {...question} })"
                            >
                              {{ selectedQuestions.includes(question.parent.id) ? 'quitar' : 'agregar' }}
                            </button>
                            <button
                              class="rounded px-2 py-1 bg-black bg-opacity-5" type="button"
                              @click="showQuestionAdded[question.parent.id] = !showQuestionAdded[question.parent.id]"
                            >
                              {{ showQuestionAdded[question.parent.id] ? 'ocultar' : 'mostrar' }} pregunta
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
                    </template>
                  </draggable>
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
import statementsApi from '../../../../api/teacher/question-bank/statements.js';
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
      statements: [],

      statementPagination: {
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

      showStatementAdded: [],
      showStatementQuestionsAdded: [],
      showQuestionAdded: [],

      selectedQuestions: [],

      selectedStatements: [],

      selectedStatementsJson: '',

      filters: {},
      selectedTags: [],
      myArray: [],

      indexes: {},
    };
  },
  watch: {
    filters: {
      handler() {
        this.getStatements();
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

    this.selectedStatements = questionnaire.latest.itemsForEdit;

    this.selectedStatements.forEach((statement) => {
      this.showStatementQuestionsAdded[statement.id] = true;

      statement.questions.forEach((question) => {
        this.selectedQuestions.push(question.parent.id);
      });
    });

    this.filters.whereSubjectId = this.subjectId;

    this.subjects = (await subjectsApi.index({'where_has_statements': true})).data;
    this.tags = (await tagsApi.index({
      'whereSubjectId': this.filters.whereSubjectId,
      'orWhereSubjectIdNull': true,
      'hasQuestionPrototypesLatest': true,
    })).data;
  },
  methods: {
    goToPage(page) {
      this.filters.page = page;
    },
    async getStatements() {
      let data = (await statementsApi.index({
        ...this.filters,
        'withQuestions': true,
        'withQuestionLatest': true,
        'withQuestionTags': true,
      })).data;

      this.statements = data.data;

      this.statementPagination = data.meta;
    },
    addQuestionOrRemove(statement, question) {
      let statementIndex = this.selectedStatements.findIndex(e => e.id === statement.id);

      if (statementIndex === -1){
        statementIndex = this.selectedStatements.push({
          ...statement,
          questions: [],
        });

        statementIndex -= 1;
      }

      let questionIndex = this.selectedStatements[statementIndex].questions.findIndex(e => e.id === question.latest.id); // BUG

      if (questionIndex !== -1) {
        this.selectedStatements[statementIndex].questions.splice(questionIndex, 1);
        this.selectedQuestions.splice(this.selectedQuestions.indexOf(question.id), 1);

        if (this.selectedStatements[statementIndex].questions.length === 0) {
          this.selectedStatements.splice(statementIndex, 1);
        }

        this.refreshJson();

        return;
      }

      this.selectedStatements[statementIndex].questions.push({
        ...question.latest,
        'parent': question,
      });

      this.selectedQuestions.push(question.id);

      this.showStatementQuestionsAdded[question.statementPrototypeId] = true;

      this.refreshJson();
    },
    refreshJson() {
      this.selectedStatementsJson = JSON.stringify(this.selectedStatements.map(e => {
        return {
          'id' : e.id,
          'questions' : e.questions.map(question => question.id),
        };
      }));

      let questions = 0;

      this.selectedStatements.forEach(statement => {
        statement.questions.forEach(question => {
          questions += 1;
          this.indexes[question.parent.id] = questions;
        });
      });
    },
    checkMove() {
      this.refreshJson();
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
