import { OK, CREATED } from '../util';

const state = {
  photos: null,
  photo: null,
  currentPage: 1,
  lastPage: 1
};

const mutations = {
  setPhotos(state, photos) {
    state.photos = photos;
  },
  setPhoto(state, photo) {
    state.photo = photo;
  },
  setComment(state, comments) {
    state.photo.comments = comments;
  },
  setCurrentPage(state, page) {
    state.currentPage = page;
  },
  setLastPage(state, page) {
    state.lastPage = page;
  },
  addComment(state, comment) {
    state.photo.comments = [comment, ...state.photo.comments];
  },
  like(state, id) {
    if (state.photos) {
      state.photos = state.photos.map(photo => {
        if (photo.id === id) {
          photo.likes_count += 1;
          photo.liked_by_user = true;
        }
        return photo;
      });
    }
    if (state.photo) {
      state.photo.likes_count += 1;
      state.photo.liked_by_user = true;
    }
  },
  unlike(state, id) {
    if (state.photos) {
      state.photos = state.photos.map(photo => {
        if (photo.id === id) {
          photo.likes_count -= 1;
          photo.liked_by_user = false;
        }
        return photo;
      });
    }
    if (state.photo) {
      state.photo.likes_count -= 1;
      state.photo.liked_by_user = false;
    }
  }
};

const actions = {
  async fetchPhotos({ commit, dispatch }, page = 1) {
    const response = await axios.get(`/api/photos/?page=${page}`);

    if (response.status !== OK) {
      dispatch('error/setCode', response.status, { root: true });
      return;
    }
    commit('setPhotos', response.data.data);
    commit('setCurrentPage', response.data.current_page);
    commit('setLastPage', response.data.last_page);
  },
  async fetchPhoto({ commit, dispatch }, id) {
    const response = await axios.get(`/api/photos/${id}`);

    if (response.status !== OK) {
      dispatch('error/setCode', response.status, { root: true });
      return;
    }
    commit('setPhoto', response.data);
  },
  async addComment({ commit }, { id, content }) {
    const response = await axios.post(`/api/photos/${id}/comments`, {
      content
    });
    if (response.status !== CREATED) {
      dispatch('error/setCode', response.status, { root: true });
      return;
    }
    commit('addComment', response.data);
  },
  async like({ commit, dispatch }, id) {
    const response = await axios.put(`/api/photos/${id}/like`);
    if (response.status !== OK) {
      dispatch('error/setCode', response.status, { root: true });
      return;
    }
    commit('like', response.data.photo_id);
  },
  async unlike({ commit, dispatch }, id) {
    const response = await axios.delete(`/api/photos/${id}/like`);
    if (response.status !== OK) {
      dispatch('error/setCode', response.status, { root: true });
      return;
    }
    commit('unlike', response.data.photo_id);
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
