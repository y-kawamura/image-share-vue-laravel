import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util';

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  signupErrorMessages: null
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
  },
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages;
  },
  setSignupErrorMessages(state, messages) {
    state.signupErrorMessages = messages;
  }
};

const actions = {
  async signup({ commit }, user) {
    const response = await axios
      .post('/api/register', user)
      .catch(err => err.response || err);

    if (response.status === CREATED) {
      commit('setApiStatus', true);
      commit('setUser', response.data);
      return;
    }
    commit('setApiStatus', false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      commit('setSignupErrorMessages', response.data.errors);
    } else {
      commit('error/setCode', response.status, { root: true });
    }
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
    if (response.status === UNPROCESSABLE_ENTITY) {
      commit('setLoginErrorMessages', response.data.errors);
    } else {
      commit('error/setCode', response.status, { root: true });
    }
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
  },
  clearErrorMessages({ commit }) {
    commit('setLoginErrorMessages', null);
    commit('setSignupErrorMessages', null);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
