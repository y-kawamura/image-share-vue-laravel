import Vue from 'vue';
import VueRouter from 'vue-router';

import store from '../store';
import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Signup from '../pages/Signup.vue';
import PhotoDetail from '../pages/PhotoDetail.vue';
import SystemError from '../pages/errors/SystemError.vue';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
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
  routes
});

export default router;
