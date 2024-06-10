import { createRouter, createWebHistory } from 'vue-router';
import PublicLayout from '@/layouts/PublicLayout.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import HomeView from '@/views/public/HomeView.vue';
import LoginView from '@/views/public/LoginView.vue';
import DashBoardView from '@/views/admin/DashBoardView.vue';

const routes = [
    {
        path: '/',
        component: PublicLayout,
        children: [
            {
                path: '',
                name: 'Home',
                component:  HomeView
            },
            {
                path: 'login',
                name: 'Login',
                component: LoginView
            }
        ]
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                name: 'DashBoard',
                component: DashBoardView
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

// router.beforeEach((to, from, next) => {

// });

export default router;