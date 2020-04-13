import Axios from 'axios';

import { OK } from '../util';

const state = {
  user: null,
  apiStatus: null
};

const getters = {
  isLoggedIn(state) {
    return !!state.user;
  },
  username(state) {
    return state.user ? state.user.name : '';
  }
};

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  setApiStatus(state, status) {
    state.apiStatus = status;
  }
};

const actions = {
  async signup({ commit }, user) {
    const response = await axios
      .post('/api/register', user)
      .catch(err => err.response || err);

    setUser(response.data);

    if (response.status === OK) {
      commit('setApiStatus', true);
      commit('setUser', response.data);
      return;
    }
    commit('setApiStatus', false);
    commit('error/setCode', response.status, { root: true });
  },
  async login({ commit }, user) {
    const response = await axios
      .post('/api/login', user)
      .catch(err => err.response || err);

    if (response.status === OK) {
      commit('setApiStatus', true);
      commit('setUser', response.data);
      return;
    }
    commit('setApiStatus', false);
    commit('error/setCode', response.status, { root: true });
  },
  async logout({ commit }) {
    const response = await axios
      .post('/api/logout')
      .catch(err => err.response || err);

    if (response.status === OK) {
      commit('setApiStatus', true);
      commit('setUser', null);
      return;
    }
    commit('setApiStatus', false);
    commit('error/setCode', response.status, { root: true });
  },
  async currentUser({ commit }) {
    const response = await axios
      .get('/api/user')
      .catch(err => err.response || err);

    if (response.statis === OK) {
      const user = response.data || null;
      commit('setApiStatus', true);
      commit('setUser', user);
      return;
    }
    commit('setApiStatus', false);
    commit('error/setCode', response.status, { root: true });
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
