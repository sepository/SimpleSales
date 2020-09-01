import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Login      from './login'
import Dashboard  from './dashboard'
import Customer   from './customer'
import Product    from './product'
import Unit       from './unit'

const router = new Router({
  mode: 'history',
  routes: [
    ...Login,
    ...Dashboard,
    ...Customer,
    ...Product,
    ...Unit,
  ]
})

function isLoggedIn() {
  return localStorage.getItem("auth");
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.authOnly)) {
    if (!isLoggedIn()) {
      next('/login');
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.guestOnly)) {
    if (isLoggedIn()) {
      next('/');
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;