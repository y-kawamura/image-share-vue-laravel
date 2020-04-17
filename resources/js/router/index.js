import Vue from 'vue';
import VueRouter from 'vue-router';

import store from '../store';
import PhotoList from '../pages/PhotoList.vue';
import Login from '../pages/Login.vue';
import Signup from '../pages/Signup.vue';
import PhotoDetail from '../pages/PhotoDetail.vue';
import SystemError from '../pages/errors/SystemError.vue';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'PhotoList',
    component: PhotoList,
    props: route => {
      const page = route.query.page;
      return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 };
    }
  },
  {
    path: '/photos/:id',
    name: 'PhotoDetail',
    component: PhotoDetail,
    props: true
  },
  {
    path: '/signup',
    name: 'Signup',
    component: Signup
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    beforeEnter(to, from, next) {
      if (store.getters['auth/isLoggedIn']) {
        next('/');
      } else {
        next();
      }
    }
  },
  {
    path: '/500',
    name: 'SystemError',
    component: SystemError
  }
];

const router = new VueRouter({
  mode: 'history',
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
  routes
});

export default router;
