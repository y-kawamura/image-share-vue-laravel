const state = {
  code: null
};

const mutations = {
  setCode(state, code) {
    state.code = code;
  }
};

const actions = {
  setCode({ commit }, code) {
    commit('setCode', code);
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
