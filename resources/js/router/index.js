import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Login          from '../components/Login'
import Dashboard      from '../components/Dashboard'
import CustomerIndex  from '../components/customer/index'
import CustomerNew    from '../components/customer/new'

const router = new Router({
  mode: 'history',
  routes: [
    { path: '/login', name: 'login', component: Login, meta: { guestOnly: true } },
    { path: '/', name: 'dashboard', component: Dashboard, meta: { authOnly: true } },
    { path: '/customer', name: 'customer.index', component: CustomerIndex, meta: { authOnly: true } },
    { path: '/customer/new', name: 'customer.new', component: CustomerNew, meta: { authOnly: true } }
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