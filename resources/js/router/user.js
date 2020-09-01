import Profile from '@/views/user/Profile'

export default [
  {
    path: '/user/profile/:userId',
    name: 'profile',
    props: true,
    meta: {
      authOnly: true
    },
    component: Profile
  },
];