import { createRouter, createWebHistory } from 'vue-router';
import PostListAll from '../Components/Blog/Post/ListAll.vue';
import PostDetail from '../Components/Blog/Post/Detail.vue';

const routes = [
  { path: '/', name: 'PostListAll', component: PostListAll, },
  { path: '/post/:id', name: 'PostDetail', component: PostDetail },
];

const router = createRouter({
  history: createWebHistory('/web'),
  routes,
});

export default router;
