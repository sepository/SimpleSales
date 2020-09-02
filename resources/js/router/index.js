import Vue from 'vue'
import Router from 'vue-router'
import store from '@/store'

Vue.use(Router)

import Login      from './login'
import Dashboard  from './dashboard'
import Customer   from './customer'
import Product    from './product'
import Unit       from './unit'
import User       from './user'

const router = new Router({
  mode: 'history',
  routes: [
    ...Login,
    ...Dashboard,
    ...Customer,
    ...Product,
    ...Unit,
    ...User,
  ]
})

function isLoggedIn() {
  return store.getters['auth/check'];
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.authOnly)) {
    if (!isLoggedIn()) {
      next({name: 'login'});
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.guestOnly)) {
    if (isLoggedIn()) {
      next({name: 'dashboard'});
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;