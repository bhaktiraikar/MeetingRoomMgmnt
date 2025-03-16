import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Dashboard from '../components/Dashboard.vue';
import BookMeeting from '../components/BookMeeting.vue';


const routes = [
  { path: '/login', component: Login },
  { path: '/dashboard', component: Dashboard },
  { path: '/book-meeting', component: BookMeeting },
  { path: '/', redirect: '/login' } // Redirect "/" to login page
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
