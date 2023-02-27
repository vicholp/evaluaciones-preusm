import { createApp } from 'vue';
// eslint-disable-next-line no-unused-vars
import Iconify from '@iconify/iconify';

import { camelizeKeys } from 'humps';

import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';

import i18n from './locales';
import pinia from './stores';

import Katex from './components/shared/katex.vue';

import VueMultiselect from './components/shared/forms/multiselect.vue';
import TeacherQuestionBankQuestionsMultiselectTags
  from './components/teacher/question-bank/questions/multiselect-tags.vue';
import TeacherQuestionBankQuestionnaireEditQuestions
  from './components/teacher/question-bank/questionnaire/edit-questions.vue';

import TeacherQuestionBankQuestionsTiptap
  from './components/teacher/question-bank/questions/tiptap.vue';

import TeacherQuestionBankStatementTiptapTextEditor
  from './components/teacher/question-bank/statement/tiptap-text-editor.vue';
import TeacherQuestionBankStatementTiptapTextReadonly
  from './components/teacher/question-bank/statement/tiptap-text-readonly.vue';

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

app.component('VueMultiselect', VueMultiselect);
app.component('TeacherQuestionBankQuesitonsMultiselectTags', TeacherQuestionBankQuestionsMultiselectTags);
app.component('TeacherQuestionBankQuestionnaireEditQuestions', TeacherQuestionBankQuestionnaireEditQuestions);
app.component('TeacherQuestionBankQuestionsTiptap', TeacherQuestionBankQuestionsTiptap);
app.component('TeacherQuestionBankStatementTiptapTextEditor', TeacherQuestionBankStatementTiptapTextEditor);
app.component('TeacherQuestionBankStatementTiptapTextReadonly', TeacherQuestionBankStatementTiptapTextReadonly);

app.component('Katex', Katex);

app.mount('#app');
