import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist';
import example from './modules/example';

Vue.use(Vuex);

const vuexLocal = new VuexPersistence({
  storage: window.localStorage,
});

export default new Vuex.Store({
  modules: {
    example,
  },
  plugins: [vuexLocal.plugin],
});
