import Index    from '@/views/user/Index'
import Profile  from '@/views/user/Profile'
import Register from '@/views/user/Register'

export default [
  {
    path: '/user',
    name: 'user.index',
    meta: {
      authOnly: true
    },
    component: Index
  },
  {
    path: '/user/profile/:userId',
    name: 'profile',
    props: true,
    meta: {
      authOnly: true
    },
    component: Profile
  },
  {
    path: '/user/register',
    name: 'user.register',
    meta: {
      authOnly: true,
      adminOnly: true
    },
    component: Register
  },
];