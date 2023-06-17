<template>
  <div>
    <div
      v-for="question of questions"
      :key="question.id"
      class="flex flex-col gap-3 py-4"
    >
      <div class="flex flex-col gap-3">
        <div class="flex flex-row gap-3 justify-between">
          <div class="flex flex-col gap-3">
            <div>
              <div
                v-if="question.latest.name"
              >
                {{ question.latest.name }}
              </div>
              <div
                v-else
              >
                <questions-tiptap-mini
                  :version-id="question.latest.id"
                />
              </div>
            </div>
            <div
              v-if="question.latest.tags.length"
              class="flex flex-row gap-3"
            >
              <div
                v-for="tag of question.latest.tags"
                :key="tag.id"
              >
                <div class="rounded py-1 px-2 bg-black bg-opacity-5 dark:bg-white dark:bg-opacity-5 text-sm w-min whitespace-nowrap">
                  {{ tag.name }}
                </div>
              </div>
            </div>
            <div v-else>
              <div class="rounded py-1 px-2 bg-black bg-opacity-0 border dark:bg-white dark:bg-opacity-0 text-sm w-min whitespace-nowrap">
                Sin etiquetas
              </div>
            </div>
          </div>
          <div class="flex gap-2">
            <button
              class="rounded px-2 py-1 bg-black bg-opacity-5"
              type="button"
              @click=" showQuestionsBody[question.id] = !showQuestionsBody[question.id];"
            >
              {{ showQuestionsBody[question.id] ? 'ocultar' : 'mostrar' }} detalles
            </button>
            <button
              class="rounded px-2 py-1 bg-black bg-opacity-5"
              type="button"
              @click="addQuestionOrRemove(question)"
            >
              {{ addedQuestions.includes(question.id) ? 'quitar' : 'agregar' }}
            </button>
          </div>
        </div>
        <div
          v-if="showQuestionsBody[question.id]"
          class="flex flex-row justify-center gap-3"
        >
          <questions-tiptap
            :editable="false"
            :version-id="question.latest.id"
          />
        </div>
      </div>
    </div>
    <v-pagination
      :initial-page="1"
      :total-pages="pagination.lastPage"
      @page-changed="goToPage"
    />
  </div>
</template>
<script>
export default {
  props: {
    questions: {
      type: Array,
      required: true,
    },
    addedQuestions: {
      type: Array,
      required: true,
    },
    pagination: {
      type: Object,
      required: true,
    },
  },
  emits: [
    'page-changed',
    'add-or-remove-question',
  ],
  data() {
    return {
      showQuestionsBody: {},
    };
  },
  methods: {
    goToPage(page) {
      this.$emit('page-changed', page);
    },
    addQuestionOrRemove(question) {
      this.$emit('add-or-remove-question', question);
    },
  },
};
</script>
