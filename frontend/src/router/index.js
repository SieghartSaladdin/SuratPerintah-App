import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from '@/layout/AppLayout.vue';
import axios from 'axios';


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: AppLayout,
      children: [
        {
          path: '/',
          name: 'dashboard',
          meta: { requiresAuth: true },
          component: () => import('../views/DashboardView.vue')
        },
        {
          path: '/suratperintah',
          name: 'suratperintah',
          meta: { requiresAuth: true },
          component: () => import('../views/SuratResmi/Kedinasan/SuratPerintah/SuratPerintahView.vue')
        },
        {
          path: '/formatt-suratperintah',
          name: 'formattsuratperintah',
          meta: { requiresAuth: true },
          component: () => import('../views/SuratResmi/Kedinasan/SuratPerintah/FormattSuratPerintahView.vue')
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      meta: { requiresUnauth: true },
      component: () => import('../views/LoginView.vue')
    },
    {
      path: '/register',
      name: 'register',
      meta: { requiresUnauth: true },
      component: () => import('../views/RegisterView.vue')
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const isAuthenticated = localStorage.getItem('token') !== null;
    if (!isAuthenticated) {
      // Jika pengguna belum login, arahkan ke halaman login
      next('/login');
    } else {
      // Jika pengguna sudah login, izinkan navigasi ke halaman yang diminta
      next();
    }
  } else if (to.meta.requiresUnauth) {
    const isAuthenticated = localStorage.getItem('token') !== null;
    if (isAuthenticated) {
      // Jika pengguna sudah login, arahkan ke halaman yang sesuai (misalnya, dashboard)
      next('/');
    } else {
      // Jika pengguna belum login, izinkan navigasi ke halaman login
      next();
    }
  } else {
    // Jika rute tidak membutuhkan autentikasi, izinkan navigasi
    next();
  }
  
  if(localStorage.getItem('token') !== null)
  {
    checkTokenAuthenticity();
  }
});

const checkTokenAuthenticity = () => {
  axios.get('/api/test', {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  })
  .then((response)  => {
  })
  .catch((error) => {
    localStorage.removeItem('token')
    router.push({
      path: '/login'
    })
  })
}


export default router
