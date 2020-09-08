import Index  from '@/views/invoice/Index'
import New    from '@/views/invoice/New'

export default [
  {
    path: '/invoice',
    name: 'invoice.index',
    meta: {
      authOnly: true
    },
    component: Index
  },
  {
    path: '/invoice/new',
    name: 'invoice.new',
    meta: {
      authOnly: true
    },
    component: New
  },
];