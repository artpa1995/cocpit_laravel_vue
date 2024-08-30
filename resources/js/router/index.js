import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';
import store from '../store';

import Home from '../components/Home.vue';
import LoginComponent from '../components/LoginComponent.vue';
import RegisterComponent from '../components/RegisterComponent.vue';
import Questions from '../components/quiz/Questions.vue';
import Profie from '../components/user/Profie.vue';
import notFound from '../components/NotFound.vue';

// admin
import AdminDashboard from '../components/admin/Dashboard.vue';
import AdminQuestions from '../components/admin/Questions.vue';


const routes = [
  { path: '/', component: Home },
  { path: '/login/', component: LoginComponent },
  { path: '/register/', component: RegisterComponent },
  { path: '/questions/', component: Questions },
  { path: '/profile', component: Profie, meta: { requiresAuth: true } },
  { path: '/admin/dashboard', component: AdminDashboard, meta: { requiresAuth: true } },
  { path: '/admin/questions', component: AdminQuestions, meta: { requiresAuth: true } },
  { 
    path: '/logout', 
    beforeEnter: (to, from, next) => {
      axios.post('/logout').then(response => {
        store.dispatch('removeUser');
        next('/login'); 
      }).catch(error => {
        console.error('Logout error', error);
        next('/login');
      });
    }
  },
  { path: '/:pathMatch(.*)*', component: notFound },
];

const router = createRouter({
  linkActiveClass: 'active',
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = store.getters.isAuthenticated;
  const user_role = store.getters.getUser.role

  
  if ((to.path === '/login' || to.path === '/register') && isAuthenticated) {
    next('/');
  } else if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login'); 
  }

  let admin_links = [
    '/admin/dashboard',
    
  ];
  if(user_role == 1  &&  admin_links.includes(to.path)) {
    next('/'); 
  }

  next();
});

export default router;


