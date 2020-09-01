import Dashboard from '@/views/dashboard/Dashboard'

export default [
  {
    path: '/',
    name: 'dashboard',
    meta: {
      authOnly: true
    },
    component: Dashboard
  },
];