<template>
  <draggable
    v-if="draggableQuestions.length"
    v-model="draggableQuestions"
    item-key="id"
    class="flex flex-col divide-y divide-black dark:divide-white divide-opacity-5 dark:divide-opacity-5"
    @start="drag=true"
    @end="drag=false; sortedQuestions()"
  >
    <template #item="{element: question, index: questionIndex}">
      <div class="flex flex-col gap-3 py-4  ">
        <div class="flex flex-col gap-3">
          <div class="flex gap-3">
            <div class="flex items-center">
              {{ questionIndex + 1 }} - &nbsp;
              <span
                v-if="question.name"
              >
                {{ question.name }}
              </span>
              <questions-tiptap-mini
                v-else
                :version-id="question.id"
              />
            </div>
            <div class="ml-auto" />
            <div class="flex gap-2">
              <button
                class="rounded px-2 py-1 bg-black bg-opacity-5"
                type="button"
                @click=" showQuestionBody[question.parent.id] = !showQuestionBody[question.parent.id];"
              >
                {{ showQuestionBody[question.parent.id] ? 'ocultar' : 'mostrar' }} detalles
              </button>
              <button
                class="rounded px-2 py-1 bg-black bg-opacity-5"
                type="button"
                @click="addQuestionOrRemove(question)"
              >
                quitar
              </button>
            </div>
          </div>
          <div
            v-if="showQuestionBody[question.parent.id]"
            class="flex flex-col items-center gap-2"
          >
            <div class="flex gap-3">
              <div>Etiquetas: </div>
              <div
                v-if="question.tags.length"
                class="flex flex-row gap-3"
              >
                <div
                  v-for="tag of question.tags"
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
            <questions-tiptap
              :editable="false"
              :version-id="question.id"
            />
          </div>
        </div>
      </div>
    </template>
  </draggable>
</template>
<script>

import draggable from 'vuedraggable';

export default {
  components: {
    draggable,
  },
  props: {
    questions: {
      type: Array,
      required: true,
    },
  },
  emits: [
    'add-or-remove-question',
    'sorted-questions',
  ],
  data() {
    return {
      showQuestionBody: {},
      draggableQuestions: [],
    };
  },
  watch: {
    questions: {
      handler() {
        this.draggableQuestions = this.questions;
      },
      depth: true,
      // inmediate: true,
    },
  },
  methods: {
    sortedQuestions() {
      this.$emit('sorted-questions', this.draggableQuestions);
    },
    addQuestionOrRemove(question) {
      this.$emit('add-or-remove-question', question.parent);
    },
  },
};
</script>
