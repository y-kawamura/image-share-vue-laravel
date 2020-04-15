const DEFAULT_TIMEOUT = 3000;

const state = {
  content: ''
};

const mutations = {
  setContent(state, { content, timeout }) {
    state.content = content;
    if (typeof timeout === 'undefined') {
      timeout = DEFAULT_TIMEOUT;
    }
    setTimeout(() => (state.content = ''), timeout);
  }
};

const actions = {
  setContent({ commit }, { content, timeout }) {
    commit('setContent', { content, timeout });
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
