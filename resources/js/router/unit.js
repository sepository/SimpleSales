import Index from '@/views/unit/Index'

export default [
  {
    path: '/unit',
    name: 'unit.index',
    meta: {
      authOnly: true
    },
    component: Index
  },
];