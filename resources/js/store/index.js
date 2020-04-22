import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth';
import error from './error';
import message from './message';
import photo from './photo';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    auth,
    error,
    message,
    photo
  }
});

export default store;
