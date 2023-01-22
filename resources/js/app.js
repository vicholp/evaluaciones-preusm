import Vue from 'vue';
// eslint-disable-next-line no-unused-vars
import Iconify from '@iconify/iconify';

import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';

import { camelizeKeys } from 'humps';

import Quilljs from './components/shared/quilljs.vue';

import i18n from './locales';
import store from './store';

Vue.filter('camelizeKeys', camelizeKeys);

// credit to @Bill Criswell for this filter
Vue.filter('truncate', (text, stop, clamp) => text.slice(0, stop) + (stop < text.length ? clamp || '...' : ''));

Sentry.init({
  Vue,
  dsn: process.env.SENTRY_DSN || null,
  environment: process.env.SENTRY_ENVIRONMENT,
  integrations: [
    new Integrations.BrowserTracing(),
  ],
  sampleRate: process.env.SENTRY_SAMPLE_RATE || false,
  tracesSampleRate: process.env.SENTRY_TRACES_SAMPLE_RATE || false,
});

// eslint-disable-next-line max-statements
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app') !== null) {
    Vue.component('Lala', Quilljs);
    const app = new Vue({
      el: '#app',
      store,
      i18n,
    });

    return app;
  }

  return false;
});
