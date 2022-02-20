import Vue from 'vue';
import VueI18n from 'vue-i18n';
import esLocale from './es';

Vue.use(VueI18n);

const texts = {
  es: esLocale,
};

export default new VueI18n({
  locale: 'es',
  texts,
});
