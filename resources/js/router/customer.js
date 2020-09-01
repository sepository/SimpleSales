import Index  from '@/views/customer/Index'
import New    from '@/views/customer/New'
import Edit   from '@/views/customer/Edit'

export default [
  {
    path: '/customer',
    name: 'customer.index',
    meta: {
      authOnly: true
    },
    component: Index
  },
  {
    path: '/customer/new',
    name: 'customer.new',
    meta: {
      authOnly: true
    },
    component: New
  },
  {
    path: '/customer/edit/:customerId',
    name: 'customer.edit',
    props: true,
    meta: {
      authOnly: true
    },
    component: Edit
  },
];