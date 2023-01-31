import { createApp } from 'vue';
// eslint-disable-next-line no-unused-vars
import Iconify from '@iconify/iconify';

import { camelizeKeys } from 'humps';

import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';

import i18n from './locales';
import pinia from './stores';

import QuillJs from './components/shared/quilljs.vue';

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

app.mount('#app');
