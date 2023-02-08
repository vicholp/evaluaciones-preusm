import { createApp } from 'vue';
// eslint-disable-next-line no-unused-vars
import Iconify from '@iconify/iconify';

import { camelizeKeys } from 'humps';

import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';

import i18n from './locales';
import pinia from './stores';

import QuillJs from './components/shared/quilljs.vue';
import VueMultiselect from './components/shared/forms/multiselect.vue';
import TeacherQuestionBankQuestionsMultiselectTags
  from './components/teacher/question-bank/questions/multiselect-tags.vue';
import TeacherQuestionBankQuestionsQuilljsReadonly
  from './components/teacher/question-bank/questions/quilljs-readonly.vue';
import TeacherQuestionBankQuestionnaireEditQuestions
  from './components/teacher/question-bank/questionnaire/edit-questions.vue';

import TeacherQuestionBankQuestionsTiptapEditor
  from './components/teacher/question-bank/questions/tiptap-editor.vue';
import TeacherQuestionBankQuestionsTiptapReadonly
  from './components/teacher/question-bank/questions/tiptap-readonly.vue';

const app = createApp();

Sentry.init({
  app,
  dsn: process.env.SENTRY_DSN || null,
  environment: process.env.SENTRY_ENVIRONMENT,
  integrations: [
    new Integrations.BrowserTracing(),
  ],
  sampleRate: process.env.SENTRY_SAMPLE_RATE || false,
  tracesSampleRate: process.env.SENTRY_TRACES_SAMPLE_RATE || false,
});

app.use(i18n);
app.use(pinia);

app.config.globalProperties.$filters = {
  camelizeKeys,
};

app.component('QuillJs', QuillJs);
app.component('VueMultiselect', VueMultiselect);
app.component('TeacherQuestionBankQuesitonsMultiselectTags', TeacherQuestionBankQuestionsMultiselectTags);
app.component('TeacherQuestionBankQuestionsQuilljsReadonly', TeacherQuestionBankQuestionsQuilljsReadonly);
app.component('TeacherQuestionBankQuestionnaireEditQuestions', TeacherQuestionBankQuestionnaireEditQuestions);
app.component('TeacherQuestionBankQuestionsTiptapEditor', TeacherQuestionBankQuestionsTiptapEditor);
app.component('TeacherQuestionBankQuestionsTiptapReadonly', TeacherQuestionBankQuestionsTiptapReadonly);

app.mount('#app');
