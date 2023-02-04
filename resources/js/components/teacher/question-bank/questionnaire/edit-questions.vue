<template>
  <div class="grid grid-cols-12 gap-3">
    <input
      type="text"
      name="questions"
      v-model="selectedQuestionsJson"
      hidden
    >
    <div class="col-span-12">
      <div class="bg-white rounded shadow dark:bg-gray-800 text-black dark:text-white dark:text-opacity-80 text-opacity-80 dark:shadow-none p-6">
        <h3 class="font-medium">
          agregar preguntas
        </h3>
        <div class="mb-4" />
        <div>
          <div class="flex flex-col divide-y divide-black dark:divide-white divide-opacity-5 dark:divide-opacity-5">
            <div class="flex flex-col gap-3">
              <div>
                <select
                  class="col-span-8 rounded h-10 dark:bg-white dark:bg-opacity-5"
                  v-model="filters['subject_id']"
                >
                  <option
                    class="dark:bg-gray-900"
                    selected
                  >
                    subject
                  </option>
                  <option
                    v-for="subject in subjects"
                    :key="subject.id"
                    :value="subject.id"
                    class="dark:bg-gray-900"
                  >
                    {{ subject.name }}
                  </option>
                </select>
              </div>
              <div class="flex gap-3">
                <VueMultiselect
                  v-model="selectedTags"
                  :options="tags"
                  :multiple="true"
                  track-by="id"
                  label="name"
                />
              </div>
            </div>
            <div
              class="flex flex-row gap-3 py-4"
              v-for="question of poolQuestions"
              :key="question.id"
            >
              <div class="flex flex-col gap-5 w-full">
                <div class="flex items-center gap-3">
                  <div class="flex flex-col gap-3">
                    <div>
                      {{ question.latest.name }}
                    </div>
                    <div class="flex flex-wrap gap-2">
                      <div
                        v-for="tag in question.latest.tags"
                        :key="tag.id"
                        class="p-1 dark:bg-white dark:bg-opacity-5 rounded text-sm"
                      >
                        {{ tag.name }}
                      </div>
                    </div>
                  </div>
                  <div class="ml-auto" />
                  <div class="flex gap-2">
                    <button
                      @click="viewQuestion(question)"
                      type="button"
                      class="p-2 dark:bg-white dark:bg-opacity-5 rounded"
                    >
                      Ver
                    </button>
                    <button
                      @click="addQuestion(question)"
                      type="button"
                      class="p-2 dark:bg-white dark:bg-opacity-5 rounded"
                    >
                      Agregar
                    </button>
                  </div>
                </div>
                <div v-if="showQuestion[question.id]">
                  <span v-html="question.latest.body" />
                </div>
              </div>
            </div>
          </div>
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
          <div class="flex flex-col divide-y divide-black dark:divide-white divide-opacity-5 dark:divide-opacity-5">
            <div
              class="flex flex-row gap-3 py-4"
              v-for="(question, index) of selectedQuestions"
              :key="question.id"
            >
              <div class="flex flex-col gap-5 w-full">
                <div class="flex items-center gap-3">
                  <div>
                    {{ index+1 }}
                  </div>
                  <div class="flex flex-col gap-3 ml-4">
                    <div>
                      {{ question.latest.name }}
                    </div>
                    <div class="flex flex-wrap gap-2">
                      <div
                        v-for="tag in question.latest.tags"
                        :key="tag.id"
                        class="p-1 dark:bg-white dark:bg-opacity-5 rounded text-sm"
                      >
                        {{ tag.name }}
                      </div>
                    </div>
                  </div>
                  <div class="ml-auto" />
                  <div class="flex gap-2">
                    <button
                      @click="viewQuestion(question)"
                      type="button"
                      class="p-2 dark:bg-white dark:bg-opacity-5 rounded"
                    >
                      Ver
                    </button>
                    <button
                      @click="removeQuestion(question)"
                      type="button"
                      class="p-2 dark:bg-white dark:bg-opacity-5 rounded"
                    >
                      Eliminar
                    </button>
                  </div>
                </div>
                <div v-if="showQuestion[question.id]">
                  <span v-html="question.latest.body" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import VueMultiselect from 'vue-multiselect';
import questionsApi from '../../../../api/teacher/question-bank/questions.js';
import tagsApi from '../../../../api/teacher/question-bank/tags.js';
import subjectsApi from '../../../../api/teacher/question-bank/subjects.js';

export default {
  components: {
    VueMultiselect,
  },
  data() {
    return {
      selectedQuestions: [],
      poolQuestions: [],
      showQuestion: [],
      tags: [],
      subjects: [],
      selectedQuestionsJson: '',
      filters: {},
      selectedTags: [],
    };
  },
  async mounted() {
    this.getQuestions();

    this.tags = (await tagsApi.index()).data;
    this.subjects = (await subjectsApi.index()).data;
  },
  watch: {
    filters: {
      handler() {
        this.getQuestions();
      },
      deep: true,
    },
    selectedTags() {
      this.filters.tags = this.selectedTags.map(e => e.id);
    },
  },
  methods: {
    async getQuestions() {
      this.poolQuestions = (await questionsApi.index({
        ...this.filters,
        'with_latest': true,
      })).data;
    },
    addQuestion(question) {
      this.selectedQuestions.push(question);
      this.poolQuestions = this.poolQuestions.filter(e => e.id !== question.id);

      this.selectedQuestionsJson = JSON.stringify(this.selectedQuestions.map(e => e.id));
    },
    viewQuestion(question) {
      this.showQuestion[question.id] = !this.showQuestion[question.id];
    },
    removeQuestion(question) {
      this.poolQuestions.push(question);
      this.selectedQuestions = this.selectedQuestions.filter(e => e.id !== question.id);

      this.selectedQuestionsJson = JSON.stringify(this.selectedQuestions.map(e => e.id));
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
