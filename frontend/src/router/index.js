import { createRouter, createWebHistory } from 'vue-router'
import signup from '@/views/auth/signup.vue'
import login from '@/views/auth/login.vue'
import { useAuthStore } from '@/stores/authStore'
import home from '@/views/home.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import Modules from '@/views/modules.vue'


const routes = [
    {
        path: "/",
        component: AppLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: '/',
                name: 'home',
                component: home,
                meta: { requiresAuth: false },
            },
            { path: "modules", name: "modules", component: Modules  },
            // { path: "admin", name: "admin", component: Admin }

        ]
    },
    {
    path: "/",
    component: AuthLayout,
    children: [
      {
        path: 'signup',
        name: 'signup',
        component: signup,
    },
    {
        path: 'login',
        name: 'login',
        meta: { requiresAuth: false },
        component: login,
    }
    ]
  }
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})

router.beforeEach((to) => {
    const auth = useAuthStore()

    if (to.meta.requiresAuth && !auth.token) {
        return { name: 'login' }
    }

    if (to.name === 'login' && auth.token) {
        return { name: 'home' }
    }


    if (to.name === 'signup' && auth.token) {
        return { name: 'home' }
    }
})

export default router
