import Index  from '@/views/invoice/Index'
import New    from '@/views/invoice/New'
import Edit   from '@/views/invoice/Edit'

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
  {
    path: '/invoice/edit/:invoiceId',
    name: 'invoice.edit',
    props: true,
    meta: {
      authOnly: true
    },
    component: Edit
  },
];