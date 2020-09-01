import Login from '@/views/login/Login'

export default [
  {
    path: '/login',
    name: 'login',
    meta: {
      guestOnly: true
    },
    component: Login
  },
];
