import { createRouter, createWebHistory } from 'vue-router';
import PostListAll from './Components/Post/ListAll.vue';
import PostDetail from './Components/Post/Detail.vue';

const routes = [
  {
    path: '/',
    name: 'PostListAll',
    component: PostListAll,
  },
  {
    path: '/post/:id',
    name: 'PostDetail',
    component: PostDetail,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
