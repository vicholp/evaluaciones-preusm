import Vue from 'vue';
// eslint-disable-next-line no-unused-vars
import Iconify from '@iconify/iconify';

import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';

import { camelizeKeys } from 'humps';

import i18n from './locales';
import store from './store';

Vue.filter('camelizeKeys', camelizeKeys);

// credit to @Bill Criswell for this filter
Vue.filter('truncate', (text, stop, clamp) => text.slice(0, stop) + (stop < text.length ? clamp || '...' : ''));

Sentry.init({
  Vue,
  dsn: '',
  integrations: [
    new Integrations.BrowserTracing(),
  ],
  tracesSampleRate: 1.0,
});

// eslint-disable-next-line max-statements
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app') !== null) {
    const app = new Vue({
      el: '#app',
      store,
      i18n,
    });

    return app;
  }

  return false;
});
