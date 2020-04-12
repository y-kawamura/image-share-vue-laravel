import Axios from 'axios';

const state = {
  user: null
};

const getters = {};

const mutations = {
  setUser(state, user) {
    state.user = user;
  }
};

const actions = {
  async signup({ commit }, user) {
    try {
      const response = await axios.post('/api/register', user);
      commit('setUser', response.data);
    } catch (error) {
      console.log(error.message);
    }
  },
  async login({ commit }, user) {
    console.log(user);
    const response = await axios.post('/api/login', user);
    commit('setUser', response.data);
  },
  async logout({ commit }) {
    await axios.post('/api/logout');
    commit('serUser', null);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
