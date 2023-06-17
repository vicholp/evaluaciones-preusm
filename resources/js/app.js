import { createApp } from 'vue';
// eslint-disable-next-line no-unused-vars
import Iconify from '@iconify/iconify';

import { camelizeKeys } from 'humps';

import * as Sentry from '@sentry/vue';

import i18n from './locales';
import pinia from './stores';

//shared

import Dropdown from './components/shared/dropdown/dropdown.vue';
import DropdownItem from './components/shared/dropdown/item.vue';
import Pagination from './components/shared/pagination.vue';
import Pagedjs from './components/shared/pagedjs.vue';

import Katex from './components/shared/katex.vue';

import VueMultiselect from './components/shared/forms/multiselect.vue';
import TeacherQuestionBankQuestionsMultiselectTags
from './components/teacher/question-bank/questions/multiselect-tags.vue';
import TeacherQuestionBankQuestionnaireEditQuestions
from './components/teacher/question-bank/questionnaires/edit-questions/edit-questions.vue';
import TeacherQuestionBankQuestionnaireEditStatements
from './components/teacher/question-bank/questionnaire/edit-statements.vue';

// tiptap
import QuestionsTiptapMini
  from './components/questions/tiptap-mini.vue';
import TeacherQuestionBankStatementTiptapText
  from './components/teacher/question-bank/statement/tiptap-text.vue';
import TeacherQuestionBankQuestionsTiptap
  from './components/teacher/question-bank/questions/tiptap.vue';

import QuestionsTiptap from './components/questions/tiptap.vue';

// dom-to-image

import TeacherQuestionBankQuestionsDomToImage
  from './components/teacher/question-bank/questions/dom-to-image.vue';

import TeacherQuestionBankQuestionnairesToImages
  from './components/teacher/question-bank/questionnaires/to-images.vue';

// results charts
import TeacherResultsChartsQuestionnaireScore
  from './components/teacher/results/charts/questionnaire-score.vue';

const app = createApp();

import.meta.glob([
  '../../public/images/**',
]);

Sentry.init({
  app,
  dsn: import.meta.env.SENTRY_DSN || null,
  environment: import.meta.env.SENTRY_ENVIRONMENT,
  integrations: [
    new Sentry.BrowserTracing(),
  ],
  sampleRate:import.meta.env.SENTRY_SAMPLE_RATE || false,
  tracesSampleRate: import.meta.env.SENTRY_TRACES_SAMPLE_RATE || false,
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
app.component('TeacherQuestionBankStatementTiptapText', TeacherQuestionBankStatementTiptapText);
app.component('TeacherQuestionBankQuestionnaireEditStatements', TeacherQuestionBankQuestionnaireEditStatements);
app.component('QuestionsTiptapMini', QuestionsTiptapMini);
app.component('Katex', Katex);
app.component('TeacherResultsChartsQuestionnaireScore', TeacherResultsChartsQuestionnaireScore);
app.component('TeacherQuestionBankQuestionsDomToImage', TeacherQuestionBankQuestionsDomToImage);

app.component('TeacherQuestionBankQuestionnairesToImages', TeacherQuestionBankQuestionnairesToImages);

app.component('QuestionsTiptap', QuestionsTiptap);

app.component('VDropdown', Dropdown);
app.component('VDropdownItem', DropdownItem);
app.component('VPagination', Pagination);
app.component('VPagedjs', Pagedjs);

app.mount('#app');
