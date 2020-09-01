import Index  from '@/views/product/Index'
import New    from '@/views/product/New'
import Edit   from '@/views/product/Edit'

export default [
  {
    path: '/product',
    name: 'product.index',
    meta: {
      authOnly: true
    },
    component: Index
  },
  {
    path: '/product/new',
    name: 'product.new',
    meta: {
      authOnly: true
    },
    component: New
  },
  {
    path: '/product/edit/:productId',
    name: 'product.edit',
    props: true,
    meta: {
      authOnly: true
    },
    component: Edit
  },
];