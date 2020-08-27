import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Login          from '../components/Login'
import Dashboard      from '../components/Dashboard'
import CustomerIndex  from '../components/customer/index'
import CustomerNew    from '../components/customer/new'
import CustomerEdit   from '../components/customer/edit'
import ProductIndex   from '../components/product/index'
import ProductNew     from '../components/product/new'
import ProductEdit    from '../components/product/edit'

const router = new Router({
  mode: 'history',
  routes: [
    { path: '/login',                     name: 'login',          component: Login,         meta: { guestOnly: true } },
    { path: '/',                          name: 'dashboard',      component: Dashboard,     meta: { authOnly: true } },
    { path: '/customer',                  name: 'customer.index', component: CustomerIndex, meta: { authOnly: true } },
    { path: '/customer/new',              name: 'customer.new',   component: CustomerNew,   meta: { authOnly: true } },
    { path: '/customer/edit/:customerId', name: 'customer.edit',  component: CustomerEdit,  meta: { authOnly: true }, props: true },
    { path: '/product',                   name: 'product.index',  component: ProductIndex,  meta: { authOnly: true } },
    { path: '/product/new',               name: 'product.new',    component: ProductNew,    meta: { authOnly: true } },
    { path: '/product/edit/:productId',   name: 'product.edit',   component: ProductEdit,   meta: { authOnly: true }, props: true },
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