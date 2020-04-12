import Vue from 'vue';
import VueRouter from 'vue-router';

import store from '../store';
import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Signup from '../pages/Signup.vue';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
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
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

export default router;
