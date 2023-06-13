<template>
  <draggable
    :list="questions"
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
              {{ questionIndex + 1 }} - &nbsp;
              <span
                v-if="question.name"
              >
                {{ question.name }}
              </span>
              <questions-tiptap-mini
                v-else
                :initial-content="question.body"
              />
            </div>
            <div class="ml-auto" />
            <div class="flex gap-2">
              <button
                class="rounded px-2 py-1 bg-black bg-opacity-5"
                type="button"
                @click=" showQuestionBody[question.parent.id] = !showQuestionBody[question.parent.id];"
              >
                {{ showQuestionBody[question.parent.id] ? 'ocultar' : 'mostrar' }} texto
              </button>
            </div>
          </div>
          <div
            v-if="showQuestionBody[question.parent.id]"
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
  data() {
    return {
      showQuestionBody: {},
    };
  },
};
</script>
