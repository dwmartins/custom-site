import { createRouter, createWebHistory } from 'vue-router';
import PublicLayout from '@/layouts/PublicLayout.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import HomeView from '@/views/public/HomeView.vue';
import LoginView from '@/views/public/LoginView.vue';
import DashBoardView from '@/views/admin/DashBoardView.vue';
import AuthService from '@/services/AuthService';
import { alertStore } from '@/store/alertStore';
import { showError } from '@/helpers/showError';

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
        path: '/app',
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                name: 'DashBoard',
                component: DashBoardView
            }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

router.beforeEach((to, from, next) => {
    if(to.meta.requiresAuth) {
        AuthService.auth().then((response) => {
            console.log(response.data)
            next();
        })
        .catch((error) => {
            if(error.statusCode === 401) {
                alertStore.addAlert('error', error.message);
                next({name: 'Login'});
            } else {
                showError(error, router);
            }
        })
    } else {
        next();
    }
});

export default router;